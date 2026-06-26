<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLombaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_lomba' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'deskripsi' => 'required',
            'poster' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'event_year' => 'required|digits:4',
            'lokasi' => 'nullable|string',
            'harga_tiket' => 'nullable|numeric|min:0',
            'juklak_juknis_link' => 'nullable|url',
            'event_start' => 'nullable|date_format:H:i',
            'event_end' => 'nullable|date_format:H:i',
            'is_save_the_date_active' => 'nullable|boolean',
            'tipe_lomba' => 'required|in:solo,kelompok',
            'whatsapp_panitia' => 'nullable|string|max:20',
            'link_grup_wa' => 'nullable|url',
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
            'nama_lomba.required' => 'Nama lomba wajib diisi.',
            'tanggal_pelaksanaan.required' => 'Tanggal pelaksanaan wajib diisi.',
            'tanggal_pelaksanaan.date' => 'Format tanggal tidak valid.',
            'deskripsi.required' => 'Deskripsi lomba wajib diisi.',
            'poster.required' => 'Poster lomba wajib diunggah.',
            'poster.image' => 'File poster harus berupa gambar.',
            'poster.max' => 'Ukuran poster maksimal 2MB.',
            'event_year.required' => 'Tahun event wajib diisi.',
            'event_year.digits' => 'Tahun harus 4 digit.',
            'tipe_lomba.required' => 'Tipe lomba wajib dipilih.',
            'tipe_lomba.in' => 'Tipe lomba harus solo atau kelompok.',
            'link_grup_wa.url' => 'Link grup WA harus berupa URL yang valid.',
            'juklak_juknis_link.url' => 'Link juklak/juknis harus berupa URL yang valid.',
        ];
    }
}
