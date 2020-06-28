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

/**
 * Interface StorageInterface.
 */
interface StorageInterface
{
    /**
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function set($key, $value);

    /**
     * @param $key
     * @param $default
     *
     * @return mixed
     */
    public function get($key, $default);

    /**
     * @param $key
     *
     * @return mixed
     */
    public function forget($key);
}
