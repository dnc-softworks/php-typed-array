<?php
/**
 * Created by PhpStorm.
 * User: douglas
 * Date: 11/5/16
 * Time: 12:08 AM
 */

namespace dncsoftworks\TypedArray;


class ArrayOfString extends AbstractTypedArray
{
    /** @inheritdoc */
    protected function isValidInput($value)
    {
        return is_string($value);
    }

    /** @inheritdoc */
    protected function getTypeName()
    {
        return 'string';
    }

}
