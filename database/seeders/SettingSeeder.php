<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'nama_event' => 'LEOS EVENT',
                'deskripsi_event' => 'Redefining the standard of excellence in event experiences.',
                'footer_text' => '© 2024 Leos Event. All Rights Reserved.',
                'primary_color' => '#712f23',
                'secondary_color' => '#c5a353',
                'accent_color' => '#d4af37',
                'font_family_url' => 'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap',
                'theme_slug' => 'default',
                'status_pendaftaran' => 'buka',
            ]
        );
    }
}
