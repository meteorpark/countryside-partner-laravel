<?php

namespace App\Http\Controllers;

use App\Exceptions\MeteoException;
use App\Services\OpenApiService;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Http\Request;
use Validator;

class OpenApiController extends Controller
{
    /** @var HttpClient */
    private $httpClient;

    /** @var OpenApiService */
    private $openApiService;

    /**
     * OpenApiController constructor.
     * @param HttpClient $httpClient
     * @param OpenApiService $openApiService
     */
    public function __construct(HttpClient $httpClient, OpenApiService $openApiService)
    {
        $this->httpClient = $httpClient;
        $this->openApiService = $openApiService;
    }


    /**
     * @param Request $request
     * @return mixed
     * @throws MeteoException
     */
    protected function machines(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'CTPRVN' => 'required',
        ]);
        if ($validator->fails()) {
            throw new MeteoException(101, $validator->errors());
        }

        if (empty($data['FCH_KND'])) {
            $data['FCH_KND'] = null;
        }

        $url = $this->openApiService->getMachineUrl(
            $data['CTPRVN'],
            $data['FCH_KND']
        );
        $response = $this->httpClient->get($url);

        return json_decode($response->getBody(), true);
    }


    /**
     * @param Request $request
     * @return mixed
     * @throws MeteoException
     */
    protected function dictionary(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'CL_NM' => 'required',
        ]);
        if ($validator->fails()) {
            throw new MeteoException(101, $validator->errors());
        }

        $url = $this->openApiService->getDictionaryUrl(
            $data['CL_NM']
        );

        $response = $this->httpClient->get($url);

        return json_decode($response->getBody(), true);
    }
}
