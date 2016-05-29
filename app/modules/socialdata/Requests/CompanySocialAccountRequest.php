<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CompanySocialAccountRequest extends Request
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
            'page_id' => 'required|max:255',
            'company_id' => 'required|max:64',
            'sm_type_id' => 'required|max:64'
        ];
    }
}
