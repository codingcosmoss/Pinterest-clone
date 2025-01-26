<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'old-password' => 'required|string',
            'new-password' => 'required|string|min:8|confirmed|different:old-password',
        ];
    }

    /**
     * Xato xabarlarini sozlash (ixtiyoriy).
     */
    public function messages(): array
    {
        return [
            'old-password.required' => 'Eski parol kiritilishi shart.',
            'new-password.required' => 'Yangi parol kiritilishi shart.',
            'new-password.min' => 'Yangi parol kamida 8 ta belgidan iborat bo‘lishi kerak.',
            'new-password.confirmed' => 'Yangi parol va tasdiqlovchi parol bir xil bo‘lishi kerak.',
            'new-password.different' => 'Yangi parol eski paroldan farq qilishi kerak.',
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
