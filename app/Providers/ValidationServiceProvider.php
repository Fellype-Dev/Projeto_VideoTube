<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Validator::extend('youtube_url', function ($attribute, $value, $parameters, $validator) {
            // Padrões para URLs do YouTube
            $patterns = [
                '~^(?:https?://)?(?:www\.)?(?:youtube\.com/watch\?v=|youtu\.be/)([^&]+)~',
                '~^(?:https?://)?(?:www\.)?(?:youtube\.com/embed/)([^/?]+)~',
                '~^(?:https?://)?(?:www\.)?(?:youtube\.com/v/)([^/?]+)~'
            ];

            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $value)) {
                    return true;
                }
            }

            return false;
        });
    }
}