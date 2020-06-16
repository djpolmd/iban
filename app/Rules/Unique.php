<?php

namespace App\Rules;

use App\Iban;
use Exception;
use Illuminate\Contracts\Validation\Rule;

class Unique implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $last_character = substr($value, 10, 14);
            $codeco = substr($value, 10, 6);
            $codlocal = substr($value, 16, 4);

            // Aici referinte eloquent nu functioneza ...
            // vom folosi un Array indexat
            $ibans = new Iban();
            $ibans1 = $ibans->where('cod_local', '=', $codlocal)
                            ->where('cod_eco', '=', $codeco)
                            ->pluck('iban');
            $i = 0;
            $var = (string)'';
            dd($ibans1);
            while ($i <= count($ibans1) - 1) {
                $var = substr($ibans1[$i], 10, 14);
                if ($var == $last_character) return false;
                $i++;
            }
            return true;
        } catch (Exception $exception){
            echo $exception;
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Ultimele 14 cifre nu sunt unicale.';
    }
}
