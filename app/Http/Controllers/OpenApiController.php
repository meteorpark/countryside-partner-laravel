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
            'ctprvn' => 'required',
            'fchkind' => 'required',
        ]);
        if ($validator->fails()) {
            throw new MeteoException(101, $validator->errors());
        }

        $url = $this->openApiService->getMachineUrl(
            $data['ctprvn'],
            $data['fchkind']
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
            'cl_nm' => 'required',
        ]);
        if ($validator->fails()) {
            throw new MeteoException(101, $validator->errors());
        }

        $url = $this->openApiService->getDictionaryUrl(
            $data['cl_nm']
        );

        $response = $this->httpClient->get($url);

        return json_decode($response->getBody(), true);
    }
}
