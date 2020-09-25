<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BrazilianPostalCode implements Rule
{

    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        return preg_match("(^[0-9]{5}([-])([0-9]{3}))", $value) > 0;
    }

    public function message()
    {
        return 'CEP inválido.';
    }
}
