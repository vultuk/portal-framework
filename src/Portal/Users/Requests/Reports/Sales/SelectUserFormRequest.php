<?php namespace Portal\Users\Requests\Reports\Sales;

use Illuminate\Foundation\Http\FormRequest;

class SelectUserFormRequest extends FormRequest
{

    public function rules()
    {
        return [
            'user_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ];
    }

    public function authorize()
    {
        return true;
    }

}