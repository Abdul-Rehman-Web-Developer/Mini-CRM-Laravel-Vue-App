<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
 use Illuminate\Contracts\Validation\Validator;
 use Illuminate\Http\Exceptions\HttpResponseException;

class AddCompanyRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:150|unique:companies,name',
            'email' => 'required|email|unique:companies,email',
            'logo'  => 'required|mimes:jpg,jpeg,png|max:2000',
            'website' => 'required|url|max:450|unique:companies,website',
        ];
    }

    public function messages()
    {
        return [
                'logo.max' => 'The :attribute must not be greater than 2MB',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
