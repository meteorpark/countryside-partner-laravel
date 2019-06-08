<?php

namespace App\Services;

use League\Uri;

/**
 * Class OpenApiChatService
 * @package App\Services
 */
class OpenApiChatService
{
    /**
     *
     */
    const API_INTRO = "/episAutoAnswerApi/webchat/msg/default/json"; // 인트로

    /** @var string  */
    private $api_host = 'http://www.okdab.kr';

    /**
     * OpenApiChatService constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getIntroUrl()
    {
        return (string)Uri\Uri::createFromString($this->api_host)
            ->withPath(self::API_INTRO);
    }


}
