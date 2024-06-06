<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'phone' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['phone' => $this->phone, 'password' => $this->password], $this->boolean('remember'))) {
            $this->throwRateLimitedException();
        }
    }

    /**
     * Ensure the login request is not rate limited.
     */
    public function ensureIsNotRateLimited(): void
    {
        // Rate limiting logic if any
    }

    /**
     * Throw a rate-limited exception.
     */
    public function throwRateLimitedException(): void
    {
        // Throwing rate limited exception logic
    }
}
