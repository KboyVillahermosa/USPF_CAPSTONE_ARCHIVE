<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DissertationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'type' => 'required|in:dissertation',
            'department' => 'required|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'abstract' => 'required',
            'keywords' => 'required|max:255',
            'file_path' => $this->isUpdateOperation() ? 'nullable|sometimes' : 'required|file|mimes:pdf,doc,docx',
            'status' => 'required|in:pending,approved,rejected',
            'rejection_reason' => 'required_if:status,rejected',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'rejection_reason.required_if' => 'A rejection reason is required when rejecting a dissertation.',
        ];
    }

    /**
     * Check if this is an update operation
     * 
     * @return bool
     */
    private function isUpdateOperation()
    {
        return $this->method() == 'PUT' || $this->method() == 'PATCH';
    }
}
