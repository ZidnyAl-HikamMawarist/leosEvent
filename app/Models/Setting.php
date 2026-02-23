<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_pendaftaran',
        'kontak',
        'status_pendaftaran',
        'nama_event',
        'deskripsi_event',
        'footer_text',
        'primary_color',
        'text_primary_color',
        'secondary_color',
        'text_secondary_color',
        'accent_color',
        'body_text_color',
        'font_family_url',
        'theme_slug',
        'about_image',
        'logo',
        'navbar_element',
        'top_image',
        'side_image_left',
        'side_image_right',
        'side_image_left_bottom',
        'side_image_right_bottom',
        'footer_image',
        'event_start',
        'event_end',
        'event_status',
        'is_save_the_date_active',
        'auto_update_status',
        'background_image',
        'background_color',
    ];
}
