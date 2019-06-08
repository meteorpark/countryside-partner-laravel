<?php

namespace App\Http\Controllers;

use App\Exceptions\MeteoException;
use App\Services\OpenApiChatService;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Http\Request;
use Validator;

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
     * @return array
     * @throws MeteoException
     */
    protected function intro() : array
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
     * @return array
     * @throws MeteoException
     */
    protected function createRoom() : array
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


    /**
     * @param Request $request
     * @return array
     * @throws MeteoException
     */
    protected function sendMessage(Request $request) : array
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'roomId' => 'required|max:20',
            'msg' => 'required|max:4000',
        ]);
        if ($validator->fails()) {
            throw new MeteoException(101, $validator->errors());
        }
        
        $url = $this->openApiChatService->getSendMessageUrl(
            $data['roomId'],
            $data['msg']
        );
        $response = $this->httpClient->get($url);
        $data = json_decode($response->getBody(), true);

        $res['result'] = $data['serverResult']['message']['text'];
        return $res;
    }
}
