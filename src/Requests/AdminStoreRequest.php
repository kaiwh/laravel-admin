<?php

namespace Kaiwh\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminStoreRequest extends FormRequest
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
            'name'                  => 'required|string',
            'email'                 => 'required|string|email|unique:admins',
            'password'              => 'required|string|min:6|max:20|confirmed',
            'password_confirmation' => 'required|string',
        ];
    }
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            // 'name' => trans('admin::admin.form.name'),
        ];
    }
}
