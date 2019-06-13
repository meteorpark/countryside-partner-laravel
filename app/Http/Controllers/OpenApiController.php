<?php

namespace App\Http\Controllers;

use App\Exceptions\MeteoException;
use App\Services\OpenApiService;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Http\Request;
use Validator;
use Exception;

/**
 * Class OpenApiController
 * @package App\Http\Controllers
 */
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


    /**
     * @param Request $request
     * @return mixed
     * @throws MeteoException
     */
    protected function specialCrops(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'year' => 'required',
            'ctprvn' => 'required',
        ]);
        if ($validator->fails()) {
            throw new MeteoException(101, $validator->errors());
        }

        $url = $this->openApiService->getSpecialCropsUrl(
            $data['year'],
            $data['ctprvn'],
        );

        $response = $this->httpClient->get($url);

        $response = $this->responseAgainApi($data['year'], $data['ctprvn'], $response, OpenApiService::API_GRID_SPECIAL_CROPS);

        return json_decode($response->getBody(), true);
    }


    /**
     * @param $year
     * @param $query
     * @param $response
     * @param $apiType
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function responseAgainApi($year, $query, $response, $apiType)
    {
        $resArray = json_decode($response->getBody(), true);


        try {

            if ($resArray[$apiType]['totalCnt'] >= 0 && $resArray[$apiType]['totalCnt'] <= 50) {

                return $response;

            } else{

                $url = $this->openApiService->getSpecialCropsUrl(
                    $year,
                    $query,
                    $resArray[$apiType]['totalCnt']
                );

                return $this->httpClient->get($url);
            }

        }catch (Exception $e) {
            throw new MeteoException($e->getCode(), "[".$resArray['result']['code']."] ".$resArray['result']['message']);
        }


    }


}

