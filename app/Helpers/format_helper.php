<?php

if (!function_exists('brand_setting')) {
    function brand_setting(string $key, $default = null)
    {
        static $cache = null;
        if ($cache === null) {
            $cache = [];
            try {
                $db = \Config\Database::connect();
                $rows = $db->table('app_settings')->get()->getResultArray();
                foreach ($rows as $r) {
                    $cache[$r['key']] = $r['value'];
                }
            } catch (\Throwable $e) {
                $cache = [];
            }
        }
        return $cache[$key] ?? $default;
    }
}

if (!function_exists('home_setting')) {
    function home_setting(string $key, $default = '')
    {
        return brand_setting('home.' . $key, $default);
    }
}

if (!function_exists('media_url')) {
    /**
     * Resolve a media path to a full URL.
     * - External URLs (http:// or https://) are returned as-is.
     * - Local paths are prefixed with base_url().
     * - Null/empty returns the fallback.
     */
    function media_url(?string $path, ?string $fallback = null): ?string
    {
        if (empty($path)) {
            return $fallback;
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        return base_url($path);
    }
}

if (!function_exists('money')) {
    function money($amount, ?int $decimals = null): string
    {
        // Always use ₹ — DB may have encoding issues on some environments
        $symbol   = '₹';
        $decimals = $decimals ?? 0;
        return $symbol . ' ' . indian_number_format((float) $amount, $decimals);
    }
}

if (!function_exists('indian_number_format')) {
    /**
     * Indian lakh/crore grouping: 12,34,567.89
     */
    function indian_number_format(float $amount, int $decimals = 0): string
    {
        $negative = $amount < 0;
        $amount = abs($amount);
        $parts = explode('.', number_format($amount, $decimals, '.', ''));
        $int = $parts[0];
        $frac = $parts[1] ?? '';

        if (strlen($int) > 3) {
            $last3 = substr($int, -3);
            $rest  = substr($int, 0, -3);
            $rest  = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest);
            $int   = $rest . ',' . $last3;
        }
        $out = $int . ($decimals > 0 ? '.' . $frac : '');
        return $negative ? '-' . $out : $out;
    }
}

if (!function_exists('app_timezone')) {
    function app_timezone(): string
    {
        return (string) brand_setting('timezone', 'Asia/Kolkata');
    }
}

if (!function_exists('to_dt')) {
    /**
     * Normalize a value into a DateTime in the app timezone.
     * Accepts a string, int (unix), DateTimeInterface, or null.
     */
    function to_dt($value): ?\DateTime
    {
        if ($value === null || $value === '' || $value === '0000-00-00 00:00:00') {
            return null;
        }
        try {
            $tz = new \DateTimeZone(app_timezone());
            if ($value instanceof \DateTimeInterface) {
                $dt = new \DateTime($value->format('Y-m-d H:i:s'), $value->getTimezone());
                $dt->setTimezone($tz);
                return $dt;
            }
            if (is_int($value) || ctype_digit((string) $value)) {
                $dt = new \DateTime('@' . $value);
                $dt->setTimezone($tz);
                return $dt;
            }
            return new \DateTime((string) $value, $tz);
        } catch (\Throwable $e) {
            return null;
        }
    }
}

if (!function_exists('app_date')) {
    function app_date($value, ?string $format = null): string
    {
        $dt = to_dt($value);
        if (!$dt) return '—';
        $format = $format ?: (string) brand_setting('date_format', 'd M Y');
        return $dt->format($format);
    }
}

if (!function_exists('app_time')) {
    function app_time($value, ?string $format = null): string
    {
        $dt = to_dt($value);
        if (!$dt) return '—';
        $format = $format ?: (string) brand_setting('time_format', 'h:i A');
        return $dt->format($format);
    }
}

if (!function_exists('app_datetime')) {
    function app_datetime($value): string
    {
        $dt = to_dt($value);
        if (!$dt) return '—';
        $d = (string) brand_setting('date_format', 'd M Y');
        $t = (string) brand_setting('time_format', 'h:i A');
        return $dt->format($d . ' · ' . $t);
    }
}

if (!function_exists('grams')) {
    function grams($value): string
    {
        return number_format((float) $value, 3) . ' g';
    }
}

if (!function_exists('carats')) {
    function carats($value): string
    {
        return number_format((float) $value, 3) . ' ct';
    }
}

if (!function_exists('purity_label')) {
    function purity_label($purity): string
    {
        $p = (float) $purity;
        if ($p >= 0.999) return '24K';
        if ($p >= 0.916) return '22K';
        if ($p >= 0.833) return '20K';
        if ($p >= 0.750) return '18K';
        if ($p >= 0.585) return '14K';
        if ($p >= 0.416) return '10K';
        return number_format($p, 3);
    }
}
