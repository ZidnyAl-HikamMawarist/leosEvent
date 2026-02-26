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
                'about_tag' => '✨ Discover Our Mission',
                'about_title' => 'Experience the Evolution of Professional Growth',
                'lomba_tag' => '🏆 Active Competitions',
                'lomba_title' => 'Unleash Your Potential',
                'lomba_subtitle' => 'Choose your field of excellence and compete with the best minds in the industry.',
                'galeri_tag' => '📸 Visual Journey',
                'galeri_title' => 'Event Highlights',
                'galeri_subtitle' => 'Relive the most memorable moments from our previous sessions and special gatherings.',
                'faq_tag' => '❓ Support Portal',
                'faq_title' => 'Frequently Asked Questions',
                'faq_subtitle' => 'Have questions? We\'ve compiled a list of the most common inquiries to help you get started quickly.',
                'reg_tag' => 'REGISTRATION OPEN',
                'reg_title' => 'Begin Your Journey With Us.',
                'reg_subtitle' => 'Secure your place at the premier event of the season. Join industry leaders and visionaries in a day of innovation.',
                'reg_feature_1' => 'Secure and fast verification process.',
                'reg_feature_2' => 'Instant confirmation via email.',
                'reg_feature_3' => '24/7 Priority support for attendees.',
                'reg_form_title' => 'Registration Form',
                'reg_form_subtitle' => 'Fill in your details to get started',
                'hero_tag' => 'THE MOST AWAITED EVENT',
                'hero_title' => 'Experience The New Standard',
                'process_title1' => 'Pendaftaran',
                'process_desc1' => 'Daftarkan diri atau tim Anda secara online melalui form yang disediakan.',
                'process_icon1' => 'bi-pencil-square',
                'process_title2' => 'Daftar Ulang',
                'process_desc2' => 'Konfirmasi kehadiran dan verifikasi berkas administrative di lokasi.',
                'process_icon2' => 'bi-check2-all',
                'process_title3' => 'Pelaksanaan Lomba',
                'process_desc3' => 'Waktunya menunjukkan kemampuan terbaik Anda dalam kompetisi.',
                'process_icon3' => 'bi-trophy',
                'countdown_tag' => '🕒 Countdown to Excellence',
                'countdown_title' => 'Save the',
                'countdown_subtitle' => 'Date',
            ]
        );
    }
}
