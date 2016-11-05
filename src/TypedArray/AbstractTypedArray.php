<?php
/**
 * Created by PhpStorm.
 * User: douglas
 * Date: 11/4/16
 * Time: 11:35 PM
 */

namespace dncsoftworks\TypedArray;


abstract class AbstractTypedArray extends \ArrayObject
{
    /**
     * @var string The current full class name
     */
    protected $fullClassName;

    /**
     * @var string The name of the type that gets checked
     */
    protected $typeName;

    /**
     * Checks if the value passed is valid type for the
     * typed array
     *
     * @param $value
     *
     * @return boolean
     */
    abstract protected function isValidInput($value);

    /**
     * Returns the name of the type the array checks for
     *
     * @return string
     */
    abstract protected function getTypeName();

    /**
     * AbstractTypedArray constructor.
     *
     * @param array  $input
     * @param int    $flags
     * @param string $iterator_class
     */
    public function __construct($input = array(), $flags = 0, $iterator_class = "ArrayIterator")
    {
        $this->fullClassName = get_class($this);

        $this->typeName = $this->getTypeName();

        if (empty($this->typeName)) {
            throw new \InvalidArgumentException("{$this->fullClassName}::typeName must be specified");
        }

        $this->isValidArray($input);

        parent::__construct($input, $flags, $iterator_class);
    }

    /**
     * Checks if the value passed is an array and validates
     * every element of it
     *
     * @param $input
     *
     * @throws \InvalidArgumentException
     */
    protected function isValidArray($input)
    {
        if (is_array($input)) {
            foreach ($input as $value) {
                if (!$this->isValidInput($value)) {
                    throw new \InvalidArgumentException(
                        "{$this->fullClassName} only accepts values of {$this->typeName} type"
                    );
                }
            }
        } else {
            throw new \InvalidArgumentException(
                "{$this->fullClassName} accepts only arrays with elements of {$this->typeName} type"
            );
        }
    }

    /** @inheritdoc */
    public function exchangeArray($input)
    {
        $this->isValidArray($input);
        return parent::exchangeArray($input);
    }

    /** @inheritdoc */
    public function offsetSet($index, $newval)
    {
        if (!$this->isValidInput($newval)) {
            throw new \InvalidArgumentException(
                "{$this->fullClassName} only accepts values of {$this->typeName} type"
            );
        }
        parent::offsetSet($index, $newval);
    }

    /** @inheritdoc */
    public function append($value)
    {
        if (!$this->isValidInput($value)) {
            throw new \InvalidArgumentException(
                "{$this->fullClassName} only accepts values of {$this->typeName} type"
            );
        }
        parent::append($value);
    }

    /**
     * Determine whether the internal array is empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        return $this->count() === 0;
    }
}
