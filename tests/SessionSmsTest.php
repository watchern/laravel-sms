<?php

/*
 * This file is part of charles/laravel-sms.
 *
 * (c) Charles <https://www.charles.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Charles\Sms\Test;

use Charles\Sms\Storage\SessionStorage;

class SessionSmsTest extends SmsTest
{
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $app['config']->set('charles.sms.storage', SessionStorage::class);
    }
}
