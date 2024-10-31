<?php


namespace App\Http\Cache;

use Illuminate\Cache\RateLimiting\Limit as RateLimitingLimit;

class Limit extends RateLimitingLimit
{
    public function __construct($key = '', int $maxAttempts = 60, $decayMinutes = 1)
    {
        $this->key = $key;
        $this->maxAttempts = $maxAttempts;
        $this->decayMinutes = $decayMinutes;
    }

    public static function perSeconds($decaySeconds, $maxAttempts)
    {
        return new static('', $maxAttempts, $decaySeconds/60.0);
    }
}
