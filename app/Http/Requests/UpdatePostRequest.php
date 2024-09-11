<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NoPostKeyword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Post;
class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3' , new NoPostKeyword],
            'description' => 'required|string|min:10',
            'creator_id' => 'exists:users,id',
            'image' => 'nullable|image'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'title.unique' => 'The title has already been taken.',
            'description.required' => 'The description field is required.',
            'creator_id.exists' => 'The selected creator is invalid.',
            'image.image' => 'The image must be a valid image file.',
        ];
    }
}
