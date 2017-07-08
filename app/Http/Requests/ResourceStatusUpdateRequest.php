<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResourceStatusUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return $this->get('token') === env('APP_ACCESS_TOKEN');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'token'  => 'required',
            'status' => 'required|in:up,down',
            'uuid'   => 'required|exists:resources,id',
        ];
    }

    /**
     * Get the availability status
     *
     * @return bool
     */
    public function status() : bool
    {
        return $this->get('status') === 'up';
    }
}
