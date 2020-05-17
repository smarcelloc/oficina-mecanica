<?php

namespace App\Helpers;

class CallbackHelper
{
    public static function cep($value)
    {
        return self::mask('#####-###', $value);
    }


    public static function cpf($value)
    {
        return self::mask('###.###.###-##', $value);
    }


    public static function cnpj($value)
    {
        return self::mask('##.###.###/#####-##', $value);
    }


    public static function phone($value)
    {
        return self::mask('(##) ####-#####', $value);
    }


    /***** MASCARA PARA OS CAMPOS *****/
    private static function mask($format,$value)
    {
        $maskared = '';
        $k = 0;

        if (!empty($value)) {
            for ($i = 0; $i <= strlen($format) - 1; $i++) {
                if ($format[$i] == '#')
                    $maskared .= $value[$k++];
                else
                    $maskared .= $format[$i];
            }
        }

        return $maskared;
    }


    /******  Outras mascaras callback   ******/
    public static function date($data)
    {
        return date('d/m/Y', strtotime($data));
    }

    public static function datetime($data)
    {
        return date('d/m/Y H:i e', strtotime($data));
    }

    public static function number($str, $decimal = 0)
    {
        return number_format($str, $decimal, ",", ".");
    }
}
