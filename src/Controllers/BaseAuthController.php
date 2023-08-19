<?php

namespace Pableiros\BaseFoundationLaravel\Controllers;

use Illuminate\Support\Facades\Auth;
use Pableiros\BaseFoundationLaravel\Requests\LoginFormRequest;
use Pableiros\BaseFoundationLaravel\Controllers\Controller;

abstract class BaseAuthController extends Controller
{
    public function login(LoginFormRequest $request)
    {
        $response = $this->performLogin($request);
        return $response;
    }

    protected function createUserValues($request)
    {
        $createArray = [
            'nombre' => $request->input('nombre'),
            'apellido_paterno' => $request->input('apellido_paterno'),
            'apellido_materno' => $request->input('apellido_materno'),
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ];

        $createArray = array_merge($createArray, $this->createUserAppendExtraValues($request));
        $user = $this->createUser($createArray);

        $extraData = $user->generateTokenResponse($request);

        return $this->performSuccessResponse($extraData);
    }

    abstract protected function createUser($values);

    protected function createUserAppendExtraValues($request)
    {
        return [];
    }

    public function getUserInfo()
    {
        return auth()->user()->toArray();
    }

    // MARK: - protected

    protected function performLogin($request)
    {
        $credentials = request(['email', 'password']);
        $response = null;

        if (Auth::attempt($credentials)) {
            $user = $request->user();
            $result = $user->generateTokenResponse($request);
            $response = $this->performJsonResponse($result);
        } else {
            $message = 'El correo electrónico o la contraseña son incorrectos';
            $response = $this->performUnauthorizedResponse($message);
        }

        return $response;
    }
}