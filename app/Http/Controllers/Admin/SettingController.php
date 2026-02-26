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

    public function about()
    {
        $setting = Setting::first();
        return view('layouts.admin.settings.about', compact('setting'));
    }

    public function pendaftaran()
    {
        $setting = Setting::first();
        return view('layouts.admin.settings.pendaftaran', compact('setting'));
    }

    public function galeri()
    {
        $setting = Setting::first();
        return view('layouts.admin.settings.galeri', compact('setting'));
    }

    public function informasi()
    {
        $setting = Setting::first();
        return view('layouts.admin.settings.informasi', compact('setting'));
    }

    public function hero()
    {
        $setting = Setting::first();
        return view('layouts.admin.settings.hero', compact('setting'));
    }

    public function processFlow()
    {
        $setting = Setting::first();
        return view('layouts.admin.settings.process', compact('setting'));
    }

    public function update(Request $request)
    {
        // Check if certain switches are present in the request to avoid overriding them when not intended
        if ($request->has('has_switches')) {
            $request->merge([
                'is_save_the_date_active' => $request->has('is_save_the_date_active'),
                'auto_update_status' => $request->has('auto_update_status'),
            ]);
        }

        $data = $request->validate([
            'link_pendaftaran' => 'nullable|string',
            'kontak' => 'nullable|string',
            'status_pendaftaran' => 'nullable|string',
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
            'is_save_the_date_active' => 'nullable|boolean',
            'auto_update_status' => 'nullable|boolean',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'background_color' => 'nullable|string|max:20',
            'about_tag' => 'nullable|string',
            'about_title' => 'nullable|string',
            'lomba_tag' => 'nullable|string',
            'lomba_title' => 'nullable|string',
            'lomba_subtitle' => 'nullable|string',
            'galeri_tag' => 'nullable|string',
            'galeri_title' => 'nullable|string',
            'galeri_subtitle' => 'nullable|string',
            'galeri_limit' => 'nullable|integer|min:3',
            'faq_tag' => 'nullable|string',
            'faq_title' => 'nullable|string',
            'faq_subtitle' => 'nullable|string',
            'about_experience_label' => 'nullable|string',
            'about_experience_sublabel' => 'nullable|string',
            'hero_primary_btn_text' => 'nullable|string',
            'hero_secondary_btn_text' => 'nullable|string',
            'footer_description' => 'nullable|string',
            'reg_tag' => 'nullable|string',
            'reg_title' => 'nullable|string',
            'reg_subtitle' => 'nullable|string',
            'reg_feature_1' => 'nullable|string',
            'reg_feature_2' => 'nullable|string',
            'reg_feature_3' => 'nullable|string',
            'reg_form_title' => 'nullable|string',
            'reg_form_subtitle' => 'nullable|string',
            'hero_tag' => 'nullable|string',
            'hero_title' => 'nullable|string',
            'process_title1' => 'nullable|string',
            'process_desc1' => 'nullable|string',
            'process_icon1' => 'nullable|string',
            'process_title2' => 'nullable|string',
            'process_desc2' => 'nullable|string',
            'process_icon2' => 'nullable|string',
            'process_title3' => 'nullable|string',
            'process_desc3' => 'nullable|string',
            'process_icon3' => 'nullable|string',
            'countdown_tag' => 'nullable|string',
            'countdown_title' => 'nullable|string',
            'countdown_subtitle' => 'nullable|string',
            'about_feature1_title' => 'nullable|string|max:100',
            'about_feature1_desc' => 'nullable|string',
            'about_feature1_icon' => 'nullable|string|max:100',
            'about_feature2_title' => 'nullable|string|max:100',
            'about_feature2_desc' => 'nullable|string',
            'about_feature2_icon' => 'nullable|string|max:100',
            'about_feature3_title' => 'nullable|string|max:100',
            'about_feature3_desc' => 'nullable|string',
            'about_feature3_icon' => 'nullable|string|max:100',
            'about_feature4_title' => 'nullable|string|max:100',
            'about_feature4_desc' => 'nullable|string',
            'about_feature4_icon' => 'nullable|string|max:100',
            'about_btn_text' => 'nullable|string|max:100',
            'footer_ig_link' => 'nullable|string',
            'footer_map_link' => 'nullable|string',
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

        // Handle Background Image Separately
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

        return back()->with('success', 'Pengaturan berhasil diperbarui');
    }
}
