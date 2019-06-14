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

        $responseBody = json_decode($response->getBody(), true);

        if ($responseBody[OpenApiService::API_GRID_SPECIAL_CROPS]['totalCnt'] <= 50) {

            $url = $this->openApiService->getSpecialCropsUrl(
                $data['year'],
                $data['ctprvn'],
                $responseBody[OpenApiService::API_GRID_SPECIAL_CROPS]['totalCnt']
            );
            $response = $this->httpClient->get($url);
        }

        return json_decode($response->getBody(), true);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws MeteoException
     */
    protected function emptyHouses(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'sidonm' => 'required',
            'gubuncd' => 'required|in:F,U', // 구분(농지: F, 빈집:U)코드
            'dealtypecd' => 'required|in:DLTC01,DLTC02,DLTC03,DLTC04,DLTC05', // DLTC01:매매,DLTC02:임대(전세),DLTC03:임대(월세),DLTC04:협의후결정,DLTC05:무료임대
        ]);
        if ($validator->fails()) {
            throw new MeteoException(101, $validator->errors());
        }

        $url = $this->openApiService->getEmptyHousesUrl(
            $data['sidonm'],
            $data['gubuncd'],
            $data['dealtypecd'],
        );

        $response = $this->httpClient->get($url);

        $responseBody = json_decode($response->getBody(), true);


        if ($responseBody[OpenApiService::API_GRID_EMPTY_HOUSES]['totalCnt'] <= 50) {

            $url = $this->openApiService->getEmptyHousesUrl(
                $data['sidonm'],
                $data['gubuncd'],
                $data['dealtypecd'],
                $responseBody[OpenApiService::API_GRID_EMPTY_HOUSES]['totalCnt']
            );
            $response = $this->httpClient->get($url);
        }

        return json_decode($response->getBody(), true);
    }





}

