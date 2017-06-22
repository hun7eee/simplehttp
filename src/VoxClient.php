<?php

namespace Voximplant;

use Curl\Curl;
use Voximplant\batch\BatchContainer;
use Voximplant\exception\VoxClientException;


/**
 * Simple http client for Voximplant API
 * Class VoxClient
 * @package App\Services
 * @author Anton Schekoldin <aschekoldin@voximplant.com>
 */
class VoxClient
{
    protected $curl;
    public $endpoint;
    protected $auth_params;

    public function __construct(string $endpoint, array $auth_params = [])
    {
        $this->curl = new Curl();
        $this->endpoint = $endpoint;
        $this->auth_params = $auth_params;
    }

    /**
     * GET request
     * @param string $method
     * @param array $params
     * @param bool $auth
     * @return array
     */
    public function get(string $method, array $params = [], bool $auth = true) : array
    {
        $this->curl->get($this->endpoint . $method, $auth ? $params + $this->auth_params : $params);
        return $this->response();
    }

    /**
     * POST request
     * @param string $method
     * @param array $params
     * @param bool $auth
     * @return array
     */
    public function post(string $method, array $params = [], bool $auth = true) : array
    {
        $this->curl->post($this->endpoint . $method, $auth ? $params + $this->auth_params : $params);
        return $this->response();
    }

    /**
     * Batch request
     * @param BatchContainer $container
     * @return array
     */
    public function batch(BatchContainer $container) : array
    {
        $this->curl->setHeader('Content-Type', 'application/json; charset=utf-8');
        $this->curl->post($this->endpoint . 'Batch?', $container->build());
        return $this->response();
    }

    /**
     * Setting endpoint url
     * @param string $endpoint
     */
    public function endpoint(string $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * Setting http headers
     * @param array $headers
     */
    public function headers(array $headers)
    {
        $this->curl->setOpt(CURLOPT_HTTPHEADER, $headers);
    }

    /**
     * Getting of auth parameters
     * @return array
     */
    public function getAuthParams()
    {
        return $this->auth_params;
    }

    /**
     * Handling of response
     * @return array
     * @throws VoxClientException
     */
    public function response() : array
    {
        if ($this->curl->error) {
            throw new VoxClientException($this->curl->errorMessage, $this->curl->errorCode);
        }

        if (!$this->curl->errorCode) {
            $info = $this->curl->getInfo();
            if ($info['http_code'] !== 200) {
                throw new VoxClientException('API error!', $info['http_code']);
            }
        } else {
            throw new VoxClientException($this->curl->error, $this->curl->errorCode);
        }
        return (array)$this->curl->response;
    }

    public function __destruct()
    {
        $this->curl->close();
        $this->curl = null;
    }
}