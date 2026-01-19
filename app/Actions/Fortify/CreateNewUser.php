<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => [
                'required',
                'string',
                'regex:/^08[0-9]{8,11}$/',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ],
        [
            'phone_number.numeric' => 'The phone number must be numeric.',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'phone_number' => $input['phone_number'],
            'password' => Hash::make($input['password']),
        ]);

        return $user;
    }
}
