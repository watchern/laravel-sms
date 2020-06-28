<?php

/*
 * This file is part of charles/laravel-sms.
 *
 * (c) Charles <https://www.charles.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Charles\Sms\Storage;

use Cache;

/**
 * Class CacheStorage.
 */
class CacheStorage implements StorageInterface
{
    /**
     * @var int
     */
    protected static $lifetime = 120;

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        Cache::put($key, $value, self::$lifetime);
    }

    /**
     * @param $key
     * @param $default
     *
     * @return mixed
     */
    public function get($key, $default)
    {
        return Cache::get($key, $default);
    }

    /**
     * @param $key
     */
    public function forget($key)
    {
        if (Cache::has($key)) {
            Cache::forget($key);
        }
    }
}
