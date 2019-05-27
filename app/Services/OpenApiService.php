<?php

namespace App\Services;

use League\Uri;

class OpenApiService
{
    const API_GRID_MACHINES = "Grid_20141119000000000080_1"; //  농기계 현황
    const API_GRID_DICTIONARY = "Grid_20151230000000000339_1"; // 농업용어

    /** @var ?string */
    private $api_key = null;

    /** @var string  */
    private $api_endpoint = 'http://211.237.50.150:7080';

    /** @var ?string */
    private $api_call_url = null;

    /**
     * OpenApiService constructor.
     */
    public function __construct()
    {
        $this->api_key = config('open_api.key');
        $this->api_call_url = $this->api_endpoint."/openapi/".$this->api_key;
    }

    /**
     * @param string $ctprvn
     * @param string $fchKind
     * @return string
     */
    public function getMachineUrl(string $ctprvn, string $fchKind)
    {
        $queryParams = [
            'YEAR' => 2014,
            'CTPRVN' => $ctprvn,
        ];
        if (!empty($fchKind)) {
            $queryParams['FCH_KND'] = $fchKind;
        }

        return (string)Uri\Uri::createFromString($this->api_call_url)
            ->withPath('/json/'.static::API_GRID_MACHINES.'/1/100')
            ->withQuery(Uri\build_query($queryParams));
    }

    /**
     * @param string $clNm
     * @return string
     */
    public function getDictionaryUrl(string $clNm)
    {
        $queryParams = [
            'cl_nm' => $clNm,
        ];

        return (string)Uri\Uri::createFromString($this->api_call_url)
            ->withPath("/openapi/".$this->api_key.'/json/'.static::API_GRID_DICTIONARY.'/1/100')
            ->withQuery(Uri\build_query($queryParams));
    }
}
