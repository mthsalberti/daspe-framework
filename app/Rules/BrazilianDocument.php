<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BrazilianDocument implements Rule
{

    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        return ($this->validateCpfCnpj($attribute, $value) && $this->validateFormatoCpfCnpj($attribute, $value));
    }

    public function message()
    {
        return 'CPF ou CNPJ inválido.';
    }

    protected function validateCpfCnpj($attribute, $value)
    {
        return ($this->validateCpf($attribute, $value) || $this->validateCnpj($attribute, $value));
    }

    protected function validateCpf($attribute, $value)
    {
        $c = preg_replace('/\D/', '', $value);
        if (strlen($c) != 11 || preg_match("/^{$c[0]}{11}$/", $c)) {
            return false;
        }
        for ($s = 10, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--) ;
        if ($c[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }
        for ($s = 11, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--) ;
        if ($c[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }
        return true;
    }

    protected function validateCnpj($attribute, $value)
    {
        $c = preg_replace('/\D/', '', $value);
        if (strlen($c) != 14 || preg_match("/^{$c[0]}{14}$/", $c)) {
            return false;
        }
        $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        for ($i = 0, $n = 0; $i < 12; $n += $c[$i] * $b[++$i]) ;
        if ($c[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }
        for ($i = 0, $n = 0; $i <= 12; $n += $c[$i] * $b[$i++]) ;
        if ($c[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }
        return true;
    }


    protected function validateFormatoCpfCnpj($attribute, $value)
    {
        return $this->validateFormatoCpf($attribute, $value) || $this->validateFormatoCnpj($attribute, $value);
    }

    protected function validateFormatoCpf($attribute, $value)
    {
        return preg_match('/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', $value) > 0;
    }

    protected function validateFormatoCnpj($attribute, $value)
    {
        return preg_match('/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/', $value) > 0;
    }



}
