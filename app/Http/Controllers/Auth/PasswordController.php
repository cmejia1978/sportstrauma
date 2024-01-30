<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $subject = 'Reinicio de contraseña';

    protected $redirectTo = '/';
    protected $redirectPath = '/';

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validateSendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email'], ['email.required' => 'Debe ingrasar un correo', 'email.email' => 'Debe ingresar un correo válido']);
    }

    protected function getResetValidationMessages()
    {
        return [
            'token.required' => 'Debe haber un token',
            'password.required' => 'Debe ingresar una contraseña',
            'password.confirmed' => 'La confirmación de la contraseña no concuerda',
            'password.min' => 'La nueva contraseña debe tener un mínimo de 6 caracteres',
        ];
    }

}
