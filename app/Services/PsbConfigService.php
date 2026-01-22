<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class PsbConfigService
{
    public static function get(string $key, $default = null)
    {
        return Cache::remember(
            "psb_config_{$key}",
            now()->addMinutes(5),
            fn () => DB::table('psb_configs')
                ->where('key', $key)
                ->where('is_active', true)
                ->value('value') ?? $default
        );
    }
}