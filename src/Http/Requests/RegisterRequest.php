<?php

namespace Wauxhall\VkAppsAuth\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Wauxhall\VkAppsAuth\Exceptions\InvalidConfigException;
use Wauxhall\VkAppsAuth\Exceptions\InvalidInputException;
use Wauxhall\VkAppsAuth\Http\Requests\Rules\Phone as PhoneRule;

class RegisterRequest extends FormRequest
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
     * @throws InvalidConfigException
     */
    public function rules() : array
    {
        return $this->mapNamedRulesToFields();
    }

    /**
     * Named rules. Keys of array are not request parameter names, but the names of validation rules. It provides more flexible configuration
     *
     * @return array
     * @throws InvalidConfigException
     */
    public function namedRules() : array
    {
        $uniques = $this->createUniqueRules([ 'phone', 'email' ]);

        $rules =  [
            'name'  => 'required|string|max:255',
            'email' => [ 'required', 'email', 'max:255' ],
            'phone' => [ 'required', new PhoneRule ]
        ];

        if(!empty($uniques['email'])) {
            $rules['email'][] = $uniques['email'];
        }

        if(!empty($uniques['phone'])) {
            $rules['phone'][] = $uniques['phone'];
        }

        return $rules;
    }

    /**
     * @param $for
     * @return array
     * @throws InvalidConfigException
     */
    public function createUniqueRules($for) : array
    {
        $auth_provider = config('auth.guards.api.provider');

        if (is_null($auth_provider)) {
            throw new InvalidConfigException('Ошибка в конфиге auth.php: невозможно определить провайдера аутентификации в auth.guards.api');
        }

        if(!is_array($for)) $for = [ $for ];

        $response = [];

        foreach(config('vkapps.register_fields') as $key => $field) {
            if($search_key = array_search($field['validation_rule_key'], $for)) {
                $response[ $for[$search_key] ] = 'unique:' . $auth_provider . '.' . $field['db_column_name'];
            }
        }

        return $response;
    }

    /**
     * Match config parameters to rule names from "namedRules" method
     *
     * @return array
     * @throws InvalidConfigException
     */
    public function mapNamedRulesToFields() : array
    {
        $rules = $this->namedRules();
        $response = [];

        foreach(config('vkapps.register_fields') as $key => $field) {
            if( isset($rules[$field['validation_rule_key']]) ) {
                $response[$key] = $rules[$field['validation_rule_key']];
            }
        }

        return $response;
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
            'string'   => 'Поле :attribute должно быть строкой',
            'unique'   => 'Поле :attribute должно быть уникально',
            'numeric'  => 'Поле :attribute должно быть числовым'
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
