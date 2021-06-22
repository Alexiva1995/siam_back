<?php

namespace App\Traits;

trait CardNumber
{
    public static function generateCardNumber() {
        $rand = '';
        for ($i = 1; $i < 16; $i++) {
            $rand .= rand(0, 9);
        }
        $numberArray = array_reverse(str_split($rand));

        // Genero un digito verificador segun el algoritmo de Luhn
        $sum = 0;
        for ($index = 0; $index < count($numberArray); $index++) {
            $digit = (int)$numberArray[$index];
            if ($index % 2 == 0) {
                $result = $digit * 2;
                $sum += ($result >= 10) ? $result - 9 : $result;
            } else {
                $sum += $digit;
            }
        }
        return $rand . (10 - ($sum % 10 ?: 10));
    }
}