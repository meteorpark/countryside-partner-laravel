<?php

namespace App\Http\Controllers;

use App\Exceptions\MeteoException;
use App\Services\OpenApiChatService;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Http\Request;
use Validator;
use Exception;

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
        $responseDecode = json_decode($response->getBody(), true);

        if ($responseDecode['status'] === "OK") {
            $result['text'] = preg_replace(
                "/\..\/../",
                "http://www.okdab.kr/episAutoAnswerApi",
                $responseDecode['result']['message']['text']
            );

            return $result;
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
        $responseDecode = json_decode($response->getBody(), true);

        if ($responseDecode['status'] === "OK") {
            $result['roomId'] = $responseDecode['result']['roomId'];
            return $result;
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
            $data['msg'],
        );
        $response = $this->httpClient->get($url);
        $responseDecode = json_decode($response->getBody(), true);

        try{

            $result['result'] = $responseDecode['serverResult']['message']['text'];

            return $result;

        }catch (Exception $e){

            throw new MeteoException(300, $e->getMessage());
        }

    }
}
