<?php

namespace Voximplant;

use Curl\Curl;
use Voximplant\batch\BatchCollection;
use Voximplant\batch\BatchContainer;
use Voximplant\exception\VoxClientException;


/**
 * Proxy for simple http client for Voximplant API
 * Class VoxClientProxy
 * @package Voximplant
 * @author Anton Schekoldin <aschekoldin@voximplant.com>
 */
class VoxClientProxy
{
    public $client;

    public function __construct(VoxClient $client)
    {
        $this->client = $client;
    }

    /**
     * GET request
     * @param string $method
     * @param array $params
     * @return array
     */
    public function get(string $method, array $params = []) : array
    {
        $this->client->get($method, $params);
        return $this->handleResponse();
    }

    /**
     * POST request
     * @param string $method
     * @param array $params
     * @return array
     */
    public function post(string $method, array $params = []) : array
    {
        $this->client->get($method, $params);
        return $this->handleResponse();
    }

    /**
     * Batch request wrapper method
     * @param BatchContainer $container
     * @return BatchCollection
     */
    public function batch(BatchContainer $container) : BatchCollection
    {
        $this->client->batch($container);
        $response = $this->handleResponse();
        return new BatchCollection($response);
    }

    /**
     * Setting endpoint url
     * @param string $endpoint
     */
    public function endpoint(string $endpoint)
    {
        $this->client->endpoint($endpoint);
    }

    /**
     * Setting http headers
     * @param array $headers
     */
    public function headers(array $headers)
    {
        $this->client->headers($headers);
    }

    /**
     * Handling of http client response
     * @return mixed
     * @throws VoxClientException
     */
    public function handleResponse()
    {
        $result = $this->client->response();
        if (isset($result['error'])) {
            throw new VoxClientException($result['error']->msg, $result['error']->code);
        }
        return $result['result'];
    }
}