<?php
/**
 * Created by PhpStorm.
 * User: douglas
 * Date: 11/5/16
 * Time: 12:06 AM
 */

namespace dncsoftworks\TypedArray;


class ArrayOfFloat extends AbstractTypedArray
{
    /** @inheritdoc */
    protected function isValidInput($value)
    {
        return is_float($value);
    }

    /** @inheritdoc */
    protected function getTypeName()
    {
        return 'float';
    }

}
