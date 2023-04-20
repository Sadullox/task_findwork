<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ResponseAble;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class TestCheckRequest extends FormRequest
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
        return [
            'moderator_id'=> 'required|integer',
            'question_answers.*.question_id'=> 'required|integer',
            'question_answers.*.test_type'=> 'required|in:unique,multiple,closed',
            // 'question_answers.*.answer_id'=> 'required|integer',
        ];
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
