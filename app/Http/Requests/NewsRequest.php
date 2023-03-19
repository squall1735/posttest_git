<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules() {
        return [
            'header' => 'required|string|max:255',
            'category_id' => 'required',
            'preview_picture' => 'required',
        ];
    }

    public function messages() {
        return [
            'header.required' => "กรุณาระบุ 'หัวข้อ'",
            'category_id.required' => "กรุณาเลือก 'ประเภทข่าว'",
            'preview_picture.required' => "กรุณาเลือก 'ภาพตัวอย่าง'",
        ];
    }
}
