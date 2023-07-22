<?php

namespace Pableiros\BaseFoundationLaravel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseUserFormRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function getNombreRules()
    {
        return [
            'nombre' => 'required|min:2|max:50',
            'apellido_paterno' => 'required|min:2|max:50',
            'apellido_materno' => 'nullable|min:2|max:50',
        ];
    }

    protected function getEmailRules()
    {
        return 'required|string|email|unique:users';
    }
}
