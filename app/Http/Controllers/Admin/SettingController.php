<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('layouts.admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->merge([
            'is_save_the_date_active' => $request->has('is_save_the_date_active'),
            'auto_update_status' => $request->has('auto_update_status'),
        ]);

        $data = $request->validate([
            'link_pendaftaran' => 'nullable|string',
            'kontak' => 'nullable|string',
            'status_pendaftaran' => 'required',
            'nama_event' => 'nullable|string',
            'deskripsi_event' => 'nullable|string',
            'footer_text' => 'nullable|string',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'navbar_element' => 'nullable|string',
            'top_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'side_image_left' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'side_image_right' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'side_image_left_bottom' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'side_image_right_bottom' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'footer_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'primary_color' => 'nullable|string|max:20',
            'text_primary_color' => 'nullable|string|max:20',
            'secondary_color' => 'nullable|string|max:20',
            'text_secondary_color' => 'nullable|string|max:20',
            'accent_color' => 'nullable|string|max:20',
            'body_text_color' => 'nullable|string|max:20',
            'font_family_url' => 'nullable|string',
            'theme_slug' => 'nullable|string',
            'event_start' => 'nullable|date_format:Y-m-d H:i',
            'event_end' => 'nullable|date_format:Y-m-d H:i',
            'event_status' => 'nullable|string',
            'is_save_the_date_active' => 'required|boolean',
            'auto_update_status' => 'required|boolean',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'background_color' => 'nullable|string|max:20',
        ]);

        $setting = Setting::first();

        $imageFields = ['about_image', 'logo', 'top_image', 'side_image_left', 'side_image_right', 'side_image_left_bottom', 'side_image_right_bottom', 'footer_image'];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old image if exists
                if ($setting && $setting->$field) {
                    if (file_exists(storage_path('app/public/' . $setting->$field))) {
                        unlink(storage_path('app/public/' . $setting->$field));
                    }
                }
                $data[$field] = $request->file($field)->store('settings', 'public');
            }
        }

        // Handle Background Image Separately to support deletion
        if ($request->hasFile('background_image')) {
            if ($setting && $setting->background_image) {
                if (file_exists(storage_path('app/public/' . $setting->background_image))) {
                    unlink(storage_path('app/public/' . $setting->background_image));
                }
            }
            $data['background_image'] = $request->file('background_image')->store('settings', 'public');
        } elseif ($request->has('delete_background_image') && $setting && $setting->background_image) {
            if (file_exists(storage_path('app/public/' . $setting->background_image))) {
                unlink(storage_path('app/public/' . $setting->background_image));
            }
            $data['background_image'] = null;
        }

        Setting::updateOrCreate(
            ['id' => 1],
            $data
        );

        return back()->with('success', 'Settings berhasil diperbarui');
    }
}
