<?php

namespace Pableiros\BaseFoundationLaravel\Requests;

trait RFCFormRequestTrait
{
    public function getRFCRules($rfc)
    {
        $rules = null;

        if (strlen($rfc) > 0) {
            $rfcLength = strlen($rfc);

            if ($rfcLength == 14) {
                $rules = $this->getPersonaFisicaRules();
            } else {
                $rules = $this->getPersonaMoralRules();
            }
        } else {
            $rules = 'required';
        }

        return $rules;
    }

    protected function getPersonaFisicaRules()
    {
        return ['regex:/[A-Z,Ñ&]{4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z|\\d]{3}+/'];
    }

    protected function getPersonaMoralRules()
    {
        return ['regex:/[A-Z,Ñ&]{3}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z|\\d]{3}+/'];
    }
}