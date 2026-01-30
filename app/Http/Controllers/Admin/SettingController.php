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
        $data = $request->validate([
            'link_pendaftaran' => 'nullable|string',
            'kontak' => 'nullable|string',
            'status_pendaftaran' => 'required',
            'nama_event' => 'nullable|string',
            'deskripsi_event' => 'nullable|string',
            'footer_text' => 'nullable|string',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $setting = Setting::first();

        if ($request->hasFile('about_image')) {
            // Delete old image if exists
            if ($setting && $setting->about_image) {
                if (file_exists(storage_path('app/public/' . $setting->about_image))) {
                    unlink(storage_path('app/public/' . $setting->about_image));
                }
            }
            $data['about_image'] = $request->file('about_image')->store('settings', 'public');
        }

        Setting::updateOrCreate(
            ['id' => 1],
            $data
        );

        return back()->with('success', 'Settings berhasil diperbarui');
    }
}
