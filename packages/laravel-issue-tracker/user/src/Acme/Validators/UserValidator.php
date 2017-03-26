<?php
namespace LaravelIssueTracker\User\Acme\Validators;

use App\User;
use LaravelIssueTracker\Core\Acme\Validators\Validator;

/**
 * Class UserValidator
 * @package LaravelIssueTracker\User\Acme\Validators
 */
class UserValidator extends Validator {

    protected static $rules = [
        'default' => [
            'email' => 'required',
        ],

        'make' => [
            'email' => 'required|email',
            'profile.name' => 'required',
            'password' => 'required'
        ],

        'update' => [
            'email' => 'required',
        ]
    ];

    /**
     * @var array
     */
    protected static $messages = [
        'profile.name.required' => 'The name field is required.'
    ];

    /**
     * @param $email
     * @return mixed
     */
    public function exists($email)
    {
        return User::where('email', $email);
    }

}