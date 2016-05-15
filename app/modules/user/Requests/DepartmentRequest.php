<?php
/**
 * Created by PhpStorm.
 * User: sr
 * Date: 3/2/16
 * Time: 4:26 PM
 */

namespace App\Http\Requests;

use App\Http\Requests;
use Route;
use Input;

class DepartmentRequest extends Request
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
        $id = Route::input('id')?Route::input('id'):'';


        return [
            'title' => 'required|max:64|unique:department,title,'.$id,
        ];
    }
}