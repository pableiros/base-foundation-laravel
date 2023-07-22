<?php

namespace Pableiros\BaseFoundationLaravel\Requests;

class UpdateUserFormRequest extends BaseUserFormRequest
{
    public function rules()
    {
        $rules = $this->getNombreRules();

        if ($this->input('email') == '' || $this->input('email') == null) {
            $rules['email'] = 'required|email';
        } else if ($this->input('email') != auth()->user()->email) {
            $rules['email'] = $this->getEmailRules();
        }

        return $rules;
    }
}
