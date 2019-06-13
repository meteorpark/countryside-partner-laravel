<?php

namespace App\Services;

use League\Uri;

/**
 * Class OpenApiService
 * @package App\Services
 */
class OpenApiService
{
    /** @var ?string */
    private $api_key = null;

    /** @var string  */
    private $api_call_url = 'http://211.237.50.150:7080';

    /**
     * OpenApiService constructor.
     */
    public function __construct()
    {
        $this->api_key = config('open_api.key');
    }

    /**
     *
     */
    const API_PAGE_LIMIT = 200;
    /**
     *
     */
    const API_GRID_MACHINES = "Grid_20141119000000000080_1"; //  농기계 현황
    /**
     *
     */
    const API_GRID_DICTIONARY = "Grid_20151230000000000339_1"; // 농업용어
    /**
     *
     */
    const API_GRID_SPECIAL_CROPS = "Grid_20141119000000000065_1"; // 특용작물생산통계

    /**
     * @param string $ctprvn
     * @param string $fch_knd
     * @return string
     */
    public function getMachineUrl(string $ctprvn, string $fch_knd = null) : string
    {
        $queryParams = [
            'YEAR' => 2014,
            'CTPRVN' => $ctprvn,
        ];
        if (!empty($fch_knd)) {
            $queryParams['FCH_KND'] = $fch_knd;
        }

        return (string)Uri\Uri::createFromString($this->api_call_url)
            ->withPath("/openapi/".$this->api_key.'/json/'.static::API_GRID_MACHINES.'/1/'.self::API_PAGE_LIMIT)
            ->withQuery(Uri\build_query($queryParams));
    }

    /**
     * @param string $clNm
     * @return string
     */
    public function getDictionaryUrl(string $clNm) : string
    {
        $queryParams = [
            'CL_NM' => $clNm,
        ];

        return (string)Uri\Uri::createFromString($this->api_call_url)
            ->withPath("/openapi/".$this->api_key.'/json/'.static::API_GRID_DICTIONARY.'/1/'.self::API_PAGE_LIMIT)
            ->withQuery(Uri\build_query($queryParams));
    }


    /**
     * @param int $year
     * @param string $ctprvn
     * @param int $limit
     * @return string
     */
    public function getSpecialCropsUrl(int $year, string $ctprvn, int $limit = 50) : string
    {
        $queryParams = [
            'YEAR' => $year,
            'CTPRVN' => $ctprvn,
        ];

        return (string)Uri\Uri::createFromString($this->api_call_url)
            ->withPath("/openapi/".$this->api_key.'/json/'.static::API_GRID_SPECIAL_CROPS.'/1/'.$limit)
            ->withQuery(Uri\build_query($queryParams));
    }
}
