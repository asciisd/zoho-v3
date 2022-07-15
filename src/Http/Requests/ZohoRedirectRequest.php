<?php

namespace Asciisd\Zoho\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string code
 */
class ZohoRedirectRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required',
        ];
    }
}
