<?php

namespace App\Rules;

use App\Iban;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\App;

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
        $last_character = substr($value, 10,14);
        // Aici referinte eloquent nu functioneza ... vom folosi Array indexat
        $ibans = new Iban();
        $ibans1 = $ibans->pluck('iban');

        $i = 0;
        $var = (string)'';

         while ($i <= count($ibans1)-1)
       {
          $var =  substr($ibans1[$i], 10,14);
            if($var == $value) return false;
             $i++;
       }
            return true;
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
