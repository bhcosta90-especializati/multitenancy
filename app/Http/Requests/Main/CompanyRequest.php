<?php

namespace App\Http\Requests\Main;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
        $id = $this->route('id', 'NULL');

        return [
            'name' => ['required', 'max:191'],
            'slug' => ['required', 'max:191', "unique:companies,domain,{$id},id,deleted_at,NULL"],
        ];
    }
}
