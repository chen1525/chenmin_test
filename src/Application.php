<?php
namespace Luke\Cc;
use Hanson\Foundation\Foundation;

/**
 * Class Application
 * @package Luke\Cc
 *
 * @property \Luke\Cc\Sms       $sms
 * @property \Luke\Cc\User      $user
 * @property \Luke\Cc\Oauth     $oauth
 */
class Application extends Foundation
{
    protected $providers = [
        ServiceProvider::class
    ];
}