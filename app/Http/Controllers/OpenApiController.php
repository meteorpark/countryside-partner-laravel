<?php

namespace App\Http\Controllers;

use App\Exceptions\MeteoException;
use App\Services\OpenApiService;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Http\Request;
use Validator;

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
     * @return array
     * @throws MeteoException
     */
    protected function machines(Request $request) : array
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
     * @return array
     * @throws MeteoException
     */
    protected function dictionary(Request $request) : array
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
     * @return array
     * @throws MeteoException
     */
    protected function specialCrops(Request $request) : array
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
            $data['ctprvn']
        );

        $response = $this->httpClient->get($url);

        $responseBody = json_decode($response->getBody(), true);

        if ($responseBody[OpenApiService::API_GRID_SPECIAL_CROPS]['totalCnt'] > 50) {
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
     * @return array
     * @throws MeteoException
     */
    protected function emptyHouses(Request $request) : array
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
            $data['dealtypecd']
        );
        $response = $this->httpClient->get($url);


        $responseBody = json_decode($response->getBody(), true);


        if ($responseBody[OpenApiService::API_GRID_EMPTY_HOUSES]['totalCnt'] > 50) {
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


    /**
     * @param Request $request
     * @return array
     * @throws MeteoException
     */
    protected function educationFarms(Request $request) : array
    {
        $data = $request->all();

        if (!empty($data['sText'])) {
            $validator = Validator::make($data, [
                'sText' => 'required',
                'sType' => 'required|in:sThema,sLocplc,sCntntsSj', // sLocplc : 지역명,  sCntntsSj : 제목명, sThema : 주제명
            ]);
            if ($validator->fails()) {
                throw new MeteoException(101, $validator->errors());
            }
        }else {

            $data['sType'] = "";
            $data['sText'] = "";
        }

        $url = $this->openApiService->getEducationFarms(
            $data['page'],
            $data['sType'],
            $data['sText']
        );

        $xml = simplexml_load_string($this->httpClient->get($url)->getBody()->getContents());
        $i = 0;
        $eduFarms = [];
        $eduFarms['data'] = [];
        $eduFarms['totalCount'] = (int)$xml->body[0]->items[0]->totalCount;

        foreach($xml->body[0]->items[0]->item as $item) {

            $eduFarms['data'][$i]['cntntsNo'] = (string)$item->cntntsNo;
            $eduFarms['data'][$i]['cntntsSj'] = (string)$item->cntntsSj;
            $eduFarms['data'][$i]['adstrdName'] = (string)$item->adstrdName;
            $eduFarms['data'][$i]['locplc'] = (string)$item->locplc;
            $eduFarms['data'][$i]['telno'] = (string)$item->telno;
            $eduFarms['data'][$i]['imgUrl'] = (string)$item->imgUrl;
            $eduFarms['data'][$i]['imgUrl'] = (string)$item->imgUrl;
            $eduFarms['data'][$i]['thema'] = (string)$item->thema;

            $i++;
        }

        return $eduFarms;
    }



    /**
     * @param Request $request
     * @return array
     */
    protected function weekFarmInfo(Request $request) : array
    {
        $data = $request->all();

        $url = $this->openApiService->getWeekFarmInfo(
            $data['page']
        );

        $xml = simplexml_load_string($this->httpClient->get($url)->getBody()->getContents());

        $i = 0;
        $info = [];
        foreach($xml->body[0]->items[0]->item as $item) {

            $info[$i]['subject'] = (string)$item->subject;
            $info[$i]['regDt'] = (string)$item->regDt;
            $info[$i]['fileName'] = (string)$item->fileName;
            $info[$i]['downUrl'] = (string)$item->downUrl;
            $i++;
        }

        return $info;
    }


}
