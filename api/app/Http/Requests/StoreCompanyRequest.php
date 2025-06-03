<?php

namespace App\Http\Requests;

use App\Models\Company;
use App\Models\User\Ability;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreCompanyRequest extends FormRequest
{
    public function rules() {
        return [
            'name' => ['required'],
            'abn' => ['required'],
            'email' => ['required', 'email'],
            'address' => ['required'],
        ];
    }
}