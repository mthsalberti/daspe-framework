<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BrazilianPhone implements Rule
{

    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        return preg_match("(([0-9]{2})([ ]?)([0-9]?)([ ]?)([0-9]{4,5})( ?)([0-9]{4,5}))", $value) > 0;
    }

    public function message()
    {
        return 'Telefone inválido.';
    }

}
