<?php

namespace App\Http\Requests\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|unique:users,username',
            'name' => 'required',
            'role' => 'in:root,admin_po,admin_approval,admin_mrv',
            'department_id' => 'required',
            'position_ids.*' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password',
            'status' => 'required'
        ];
    }
}
