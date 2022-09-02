<?php

namespace Pallapay\PallapaySDK;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Pallapay\PallapaySDK\Exceptions\ApiException;

class Request
{
    private const DEFAULT_TIMEOUT = 60;

    protected const GET_METHOD = 'GET';
    protected const POST_METHOD = 'POST';
    protected const PATCH_METHOD = 'PATCH';
    protected const PUT_METHOD = 'PUT';
    protected const DELETE_METHOD = 'DELETE';

    /**
     * @var array $options
     */
    protected array $options = [];

    /**
     * @var array $headers
     */
    protected array $headers = [];

    /**
     * @var array $jsonParams
     */
    protected array $jsonParams = [];

    /**
     * @var array $queryParams
     */
    protected array $queryParams = [];

    /**
     * @var string $host
     */
    private string $host = '';


    /**
     * @param string $host
     * @return void
     */
    protected function setHost(string $host): void {
        $this->host = $host;
    }

    /**
     * @param string $optionName
     * @param $optionValue
     * @return void
     */
    protected function setOption(string $optionName, $optionValue = null): void {
        if ($optionValue !== [] && $optionValue != null) {
            $this->options[$optionName] = $optionValue;
        }
    }

    /**
     * @param string $jsonParamName
     * @param $jsonParamValue
     * @return void
     */
    protected function addJsonParam(string $jsonParamName, $jsonParamValue): void {
        $this->jsonParams[$jsonParamName] = $jsonParamValue;
    }
    /**
     * @param string $queryParamName
     * @param $queryParamValue
     * @return void
     */
    protected function addQueryParam(string $queryParamName, $queryParamValue): void {
        $this->queryParams[$queryParamName] = $queryParamValue;
    }

    /**
     * @param string $method
     * @param string $path
     * @return mixed
     * @throws ApiException
     * @throws GuzzleException
     */
    protected function sendRequest(string $method, string $path) {
        $this->setOption('headers', $this->headers);
        $this->setOption('json', $this->jsonParams);
        $this->setOption('query', $this->queryParams);
        $this->setOption('timeout', $this->options['timeout'] ?? self::DEFAULT_TIMEOUT);

        try {
            $client = new Client();

            $response = $client->request($method, $this->host . $path, $this->options);
            $decodedResponse = json_decode($response->getBody()->getContents(), true);

            if (is_array($decodedResponse) && isset($decodedResponse['status']) && $decodedResponse['status'] != 1)
                Throw new ApiException("Pallapay invalid response. method: ($method) url: ($this->host$path) Response:" . json_encode($decodedResponse));

            return $decodedResponse;
        } catch (RequestException $e){
            if (method_exists($e->getResponse(),'getBody')){
                $contents = $e->getResponse()->getBody()->getContents();

                $temp = json_decode($contents, true);
                if (!empty($temp)) {
                    $temp['_method'] = $method;
                    $temp['_url'] = $this->host . $path;
                } else {
                    $temp['_message'] = $e->getMessage();
                }
            } else {
                $temp['_message'] = $e->getMessage();
            }
            $temp['_httpcode'] = $e->getCode();

            throw new ApiException(json_encode($temp));
        }
    }
}
