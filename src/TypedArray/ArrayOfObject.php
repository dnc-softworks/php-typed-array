<?php

namespace dncsoftworks\TypedArray;

/**
 * Class ArrayOfObject
 *
 * Abstract class that allows the creation of "typed" arrays. Based on the name of the
 * class that extends ArrayOfObject, it creates an object that is accessible as an array
 * and accepts only instances of a particular class.
 *
 * The purpose of this class is to add semantical meaning to array typehinting in PHP
 * This is useful when you want to check if a parameter you're receiving is an actual
 * array of a specific class.
 *
 * For example, if you wanted to do the following:
 *
 * class Foo {}
 *
 * function printFooList(Foo[] $fooList) {
 *     // ... code ...
 * }
 *
 * Unfortunately, the type hint "Foo[]" is not allowed in PHP. So, you could extend
 * this class in order to emulate this behavior:
 *
 * class Foo {}
 *
 * class ArrayOfFoo extends ArrayOfObject {}
 *
 * function printFooList(ArrayOfFoo $fooList) {
 *     // ... code ...
 * }
 *
 */
abstract class ArrayOfObject extends AbstractTypedArray
{
    /**
     * @var string The target class name
     */
    private $targetClassName;

    /** @inheritdoc */
    public function __construct($input = array(), $flags = 0, $iterator_class = "ArrayIterator")
    {
        $this->validateClassName();

        parent::__construct($input, $flags, $iterator_class);
    }

    /** @inheritdoc */
    protected function isValidInput($value)
    {
        return $value instanceof $this->targetClassName;
    }

    /** @inheritdoc */
    protected function getTypeName()
    {
        return $this->targetClassName;
    }

    /**
     * Validates the current class name to determine whether the target class exists
     */
    private function validateClassName()
    {
        $fullClassName = $this->fullClassName;

        $isVariableValidClassName = $isReturnValidClassName = false;

        if (strpos($fullClassName, '\\') !== false) {
            $fullClassName = substr($fullClassName, (int) strrpos($fullClassName, '\\') + 1);
        }

        $className = '';

        if (strpos($fullClassName, 'ArrayOf') !== 0) {
            $className                = str_replace('ArrayOf', '', $this->fullClassName);
            $isVariableValidClassName = class_exists($className);
        }

        $isReturnValidClassName = class_exists((string) $this->className());

        if ($isVariableValidClassName) {
            $this->targetClassName = $className;
        } elseif ($isReturnValidClassName) {
            $this->targetClassName = $this->className();
        } else {
            throw new \InvalidArgumentException(
                'Class name must mention a valid class or className() must return a valid class name'
            );
        }

    }

    /**
     * If the class name does not contain the target class name, this method
     * should be implemented in order to return the target class name;
     *
     * @return string
     */
    protected function className()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getTargetClassName()
    {
        return $this->targetClassName;
    }

    /**
     * @return string
     */
    public function getFullClassName()
    {
        return $this->fullClassName;
    }
}
