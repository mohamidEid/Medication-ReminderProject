<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicineRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'frequency' => 'required|in:daily,twice_daily,three_times_daily',
            'start_date' => 'required|date|after_or_equal:today',
            'times' => 'required|array|min:1',
            'times.*' => 'required|date_format:H:i',
            'instructions' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'اسم الدواء مطلوب',
            'dosage.required' => 'الجرعة مطلوبة',
            'frequency.required' => 'عدد المرات مطلوب',
            'start_date.required' => 'تاريخ البدء مطلوب',
            'start_date.after_or_equal' => 'تاريخ البدء يجب أن يكون اليوم أو بعده',
            'times.required' => 'مواعيد الجرعات مطلوبة',
            'times.min' => 'يجب تحديد موعد واحد على الأقل',
        ];
    }
}
