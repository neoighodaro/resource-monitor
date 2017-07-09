<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ResourceUpdateRequest extends FormRequest
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
        $resourceId = $this->route('resource')->id;

        return [
            'name' => [
                'required',
                'between:2,15',
                Rule::unique('resources')->ignore($resourceId),
            ],
            'type' => 'required|in:power,internet'
        ];
    }
}
