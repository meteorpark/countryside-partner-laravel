<?php

namespace App\Http\Controllers;

use App\Exceptions\MeteoException;
use App\Services\OpenApiChatService;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Http\Request;

/**
 * Class OpenApiChatController
 * @package App\Http\Controllers
 */
class OpenApiChatController extends Controller
{
    /** @var HttpClient */
    private $httpClient;

    /**
     * @var OpenApiChatService
     */
    private $openApiChatService;

    /**
     * OpenApiChatController constructor.
     * @param HttpClient $httpClient
     * @param OpenApiChatService $openApiChatService
     */
    public function __construct(HttpClient $httpClient, OpenApiChatService $openApiChatService)
    {
        $this->httpClient = $httpClient;
        $this->openApiChatService = $openApiChatService;
    }

    /**
     * @return mixed
     */
    protected function intro() : string
    {
        $url = $this->openApiChatService->getIntroUrl();
        $response = $this->httpClient->get($url);
        $data = json_decode($response->getBody(), true);

        if ($data['status'] === "OK") {
            $res['text'] = preg_replace(
                "/\..\/../",
                "http://www.okdab.kr/episAutoAnswerApi",
                $data['result']['message']['text']
            );

            return $res;
        } else {
            throw new MeteoException(300);
        }
    }

    /**
     * @return mixed
     * @throws MeteoException
     */
    protected function createRoom() : string
    {
        $url = $this->openApiChatService->getCreateRoomUrl();
        $response = $this->httpClient->get($url);
        $data = json_decode($response->getBody(), true);

        if ($data['status'] === "OK") {
            $res['roomId'] = $data['result']['roomId'];
            return $res;
        } else {
            throw new MeteoException(300);
        }
    }
}
