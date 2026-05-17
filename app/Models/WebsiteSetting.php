<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'tagline',
        'email',
        'phone',
        'address',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'logo',
        'footer_text',
    ];
}
