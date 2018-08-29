<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class usernameOrEmail implements Rule
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
        if (filter_var($value,FILTER_VALIDATE_EMAIL))
        {
            return request()->validate([
                $attribute => 'required|email',
            ],['email or user name required']);
        }elseif (preg_match('/^[a-zA-Z-_]*$/',$value))
        {
            return request()->validate([
                $attribute => 'required|min:3|max:16|alpha',
            ]);
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'error  ';
    }
}
