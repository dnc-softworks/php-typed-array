<?php

namespace dncsoftworks\TypedArray;


class ArrayOfInt extends AbstractTypedArray
{
    protected function isValidInput($value)
    {
        return is_int($value);
    }

    protected function getTypeName()
    {
        return 'int';
    }
}
