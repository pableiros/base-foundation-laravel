<?php

namespace Pableiros\BaseFoundationLaravel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseFormRequest extends FormRequest
{
    public const ARRAY_RULES = ['required', 'array'];
    public const ARRAY_RULES_NULLABLE = ['nullable', 'array'];
    public const TEXT_RULES = ['required', 'max:1000'];
    public const TEXT_RULES_NULLABLE = ['nullable', 'max:1000'];
    public const NUMERIC_RULES = ['required', 'numeric', 'min:0', 'max:999999999'];
    public const NUMERIC_RULES_NULLABLE = ['nullable', 'numeric', 'min:0', 'max:999999999'];
    public const DELETED_AT = 'deleted_at,NULL';
    public const FECHA_RULES = ['required', 'date_format:Y-m-d'];
    public const FECHA_RULES_NULLABLE = ['nullable', 'date_format:Y-m-d'];
    public const CODIGO_POSTAL_RULES = ['required', 'min:10000', 'max:99999', 'numeric'];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
