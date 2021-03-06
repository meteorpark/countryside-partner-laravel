<?php

namespace App\Services;

use League\Uri;

/**
 * Class OpenApiChatService
 * @package App\Services
 */
class OpenApiChatService
{
    /** @var string  */
    private $api_host = 'http://www.okdab.kr';
    /**
     * 인트로
     */
    const API_CHAT_INTRO = "/episAutoAnswerApi/webchat/msg/default/json";
    /**
     * 채팅방 생성
     */
    const API_CHAT_CREATE_ROOM = "/episAutoAnswerApi/webchat/json";
    /**
     * 대화 하기
     */
    const API_CHAT_SEND_MESSAGE = "/episAutoAnswerApi/webchat/msg/json";
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
            ->withPath(self::API_CHAT_INTRO);
    }

    /**
     * @return string
     */
    public function getCreateRoomUrl()
    {
        return (string)Uri\Uri::createFromString($this->api_host)
            ->withPath(self::API_CHAT_CREATE_ROOM);
    }
    /**
     * @param string $roomId
     * @param string $msg
     * @return string
     */
    public function getSendMessageUrl(string $roomId, string $msg)
    {
        $queryParams = [
            'roomId' => $roomId,
            'msg' => $msg,
        ];
        return (string)Uri\Uri::createFromString($this->api_host)
            ->withPath(self::API_CHAT_SEND_MESSAGE)
            ->withQuery(Uri\build_query($queryParams));
    }
}
