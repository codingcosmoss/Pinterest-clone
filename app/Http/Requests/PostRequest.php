<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class PostRequest extends FormRequest
{
    /**
     * Foydalanuvchi ushbu so'rovni bajarishga ruxsatga ega ekanligini aniqlash.
     */
    public function authorize(): bool
    {
        return true; // Agar autentifikatsiya kerak bo'lsa, shu yerda tekshirish mumkin
    }

    /**
     * So'rov uchun validatsiya qoidalarini qaytarish.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'image' => 'required',
            'description' => 'string'
        ];
    }

    /**
     * Xato xabarlarini sozlash (ixtiyoriy).
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Title bolishi kerak',
            'image.required' => 'Image boliwi kerak',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'error'   => 403,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
