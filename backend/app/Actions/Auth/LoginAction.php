<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginAction
{
    /**
     * Handle the user login process.
     *
     * @param array $credentials
     * @return array
     * @throws ValidationException
     */
    public function __invoke(array $credentials): array
    {
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        /** @var User $user */
        $user = Auth::user();

        // Delete old tokens if needed (Optional)
        // $user->tokens()->delete();

        // Create a new token for the device
        $token = $user->createToken('api_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
