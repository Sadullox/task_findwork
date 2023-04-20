<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ResponseAble;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class AdminRequest extends FormRequest
{
    use ResponseAble;
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
        if ($this->method() == 'PUT' || $this->method() == 'PATCH'){
            return [
                'given_names'=> 'required',
                'sur_name'=> 'required',
                'position_id'=> 'required',
                // 'login' => 'required|unique:employees,login,' . \request('id'),
                // 'password'=> 'required',
            ];
        }
        else{
            return [
                'given_names'=> 'required',
                'sur_name'=> 'required',
                'position_id'=> 'required',
                // 'login'=> 'required|unique:employees',
                // 'password'=> 'required',
            ];
        }
    }

    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        return $this->sendError(
            validation_message($errors),
            __('messages.validate_error'),
            422
        );
    }
}
