<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ArraySize implements Rule
{
    protected  $maxSize = 0;
    public function __construct($maxSize)
    {
        $this->maxSize = $maxSize;
    }

    public function passes($attribute, $value)
    {
        preg_match('/(.*)([.])(.*)/', $attribute, $matches);
        if (count(request()->input($matches[1])) > $this->maxSize ||  count(request()->file($matches[1])) > $this->maxSize){
            return false;
        }
    }

    public function message()
    {
        return 'Número máximo de imagens excedido.';
    }
}
