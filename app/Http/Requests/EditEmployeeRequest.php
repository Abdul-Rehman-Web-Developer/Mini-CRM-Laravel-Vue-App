<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditEmployeeRequest extends FormRequest
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
            'employee_id' => 'required|exists:employees,id',
            'first_name' => 'required|min:3|max:150',
            'last_name' => 'required|min:3|max:150',
            'email' => 'required|email|unique:employees,email,NULL,id,company_id,' . $this->company_id,
            'phone'  => 'required|min:5|max:15|unique:employees,phone,NULL,id,company_id,' . $this->company_id,
            'company_id' => 'required|exists:companies,id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
