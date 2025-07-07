<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        Validator::make($input, [
            'dni' => ['required', 'digits:8', 'unique:users,dni'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ])->validate();

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer apis-token-15965.owdDGP7qtG5LIL5yeMa1uHju7mRPGc5g'
        ])->get('https://api.apis.net.pe/v2/reniec/dni', [
            'numero' => $input['dni']
        ]);

        $data = $response->json();

        if (!isset($data['nombres'])) {
            throw ValidationException::withMessages([
                'dni' => ['DNI no encontrado en RENIEC.'],
            ]);
        }

        return User::create([
            'dni' => $input['dni'],
            'name' => $data['nombres'],
            'last_name' => $data['apellidoPaterno'],
            'mother_last_name' => $data['apellidoMaterno'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
