<?php

namespace App\Http\Requests\Course;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourseRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', Rule::unique('courses', 'title')->ignore($this->route('course')),],
            'description' => ['required', 'string'],
            'price' => ['required', 'integer', 'min:10000'],
            'image' => ['nullable', 'image', 'max:2048'],
            'is_published' => ['boolean', 'nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Kurs nomini kiritishingiz shart.',
            'title.string' => 'Kurs nomi matn ko`rinishida bo`lishi kerak.',
            'title.max' => 'Kurs nomi 255 ta belgidan oshmasligi kerak.',
            'title.unique' => 'Bunday nomdagi kurs allaqachon mavjud.',

            'description.required' => "Kurs haqida qisqacha ma'lumot bering.",
            'description.string' => 'Kurs tavsifi matn ko`rinishida bo`lishi kerak.',

            'price.required' => 'Kurs narxini yozish talab qilinadi.',
            'price.integer' => 'Kurs narxi butun son bo`lishi kerak.',
            'price.min' => 'Kurs narxi :min so`mdan kichik bo`lishi mumkin emas.',

            'image.image' => 'Yuklangan fayl rasm bo`lishi kerak.',
            'image.max' => 'Rasm hajmi 2 MB dan oshmasligi kerak.',

            'is_published.boolean' => 'Nashr holati noto`g`ri qiymatga ega.',
        ];
    }
}
