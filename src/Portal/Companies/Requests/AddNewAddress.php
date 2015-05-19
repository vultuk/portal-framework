<?php namespace Portal\Companies\Requests;

use Illuminate\Foundation\Http\FormRequest as Request;

class AddNewAddress extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //@todo Nope!
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
            'description' => 'required|max:255',
            'primary'     => '',
            'address1'    => 'required|max:255',
            'address2'    => 'max:255',
            'town'        => 'max:255',
            'county'      => 'max:255',
            'postal_code' => 'required|max:255',
            'country'     => 'required|exists:country,id',
        ];
    }

}
