<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePendaftaranRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Public endpoint
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_wa' => 'required|string|max:20',
            'sekolah' => 'required|string|max:255',
            'lomba_id' => 'required|exists:lombas,id',
            'nama_pembina' => 'nullable|string|max:255',
            'no_hp_pembina' => 'nullable|string|max:20',
            'metode_pembayaran' => 'required|in:transfer,tunai',
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
            'nama.required' => 'Nama peserta wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'sekolah.required' => 'Asal sekolah wajib diisi.',
            'lomba_id.required' => 'Pilih mata lomba terlebih dahulu.',
            'lomba_id.exists' => 'Mata lomba yang dipilih tidak valid.',
            'metode_pembayaran.required' => 'Pilih metode pembayaran.',
            'metode_pembayaran.in' => 'Metode pembayaran harus transfer atau tunai.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Normalisasi spasi pada nama dan sekolah
        if ($this->has('nama')) {
            $this->merge([
                'nama' => preg_replace('/\s+/u', ' ', trim((string) $this->nama)),
            ]);
        }
        if ($this->has('sekolah')) {
            $this->merge([
                'sekolah' => preg_replace('/\s+/u', ' ', trim((string) $this->sekolah)),
            ]);
        }
    }
}
