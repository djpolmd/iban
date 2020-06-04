<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class IsAdmin extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = new User();

        $token = $this->get('token');

        $userRole = $user->where('id', $user->getUserId($token))->first()->getUserRole();

        // verificam daca utilizator este admin

        $isAdmin = ($userRole == "admin");

        return $isAdmin;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'iban' => 'required|unique:ibans|max:24',
        ];
    }
}
