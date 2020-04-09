<?php

namespace Wauxhall\VkAppsAuth\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Wauxhall\VkAppsAuth\Exceptions\InvalidInputException;
use Wauxhall\VkAppsAuth\Http\Requests\Rules\Phone as PhoneRule;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public function rules() : array
    {
        return $this->mapNamedRulesToFields();
    }

    /**
     * Named rules. Keys of array are not request parameter names, but the names of validation rules. It provides more flexible configuration
     *
     * @return array
     */
    public function namedRules() : array
    {
        return [
            'email' => 'required|email|max:255',
            'phone' => [ 'required' , new PhoneRule ]
        ];
    }

    /**
     * Match config parameters to rule names from "namedRules" method
     *
     * @return array
     */
    public function mapNamedRulesToFields() : array
    {
        return [
            config('vkapps.login_field') => $this->namedRules()[
                config('vkapps.register_fields.' . config('vkapps.login_field') . '.validation_rule_key', '')
            ]
        ];
    }

    /**
     * @return array
     */
    public function messages() : array
    {
        return [
            'required' => 'Поле :attribute обязательно',
            'email'    => 'Емейл имеет некорректный формат',
            'max'      => 'Максимальная длина поля :attribute - :max',
            'string'   => 'Поле :attribute должно быть строкой'
        ];
    }

    /**
     * Redeclare failed validation method
     *
     * @param Validator $validator
     * @throws InvalidInputException
     */
    protected function failedValidation(Validator $validator) : void
    {
        throw new InvalidInputException($validator->errors()->first());
    }
}
