<?php

namespace Negarshop;

class Negarshop_Helper
{
    public static function is_checked($val): bool
    {
        return in_array($val, ['yes', 'on', true, 1, '1']);
    }
}