<?php

namespace Voximplant\batch;

use Voximplant\exception\VoxClientException;

/**
 * Collection of batch response
 * Class BatchCollection
 * @package Voximplant\batch
 * @author Anton Schekoldin <aschekoldin@voximplant.com>
 */
class BatchCollection
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Gets response element of batch command by index
     * @param int $index
     * @return mixed
     * @throws VoxClientException
     */
    public function get(int $index)
    {
        if (isset($this->data[$index]->result)) {
            return $this->data[$index]->result;
        }
        throw new VoxClientException($this->data[$index]->error->msg, $this->data[$index]->error->code);
    }

    /**
     * Gets total count of batch command response by index
     * @param int $index
     * @return int
     */
    public function totalCountOf(int $index) : int
    {
        return isset($this->data[$index]->total_count) ? $this->data[$index]->total_count : 0;
    }


    /**
     * Gets count of batch command response by index
     * @param int $index
     * @return int
     */
    public function countOf(int $index) : int
    {
        return isset($this->data[$index]->count) ? $this->data[$index]->count : 0;
    }

    /**
     * Generator
     * @return \Generator
     */
    public function each()
    {
        foreach ($this->data as $data) {
            yield $data;
        }
    }

    /**
     * Return all of data
     * @return array
     */
    public function all()
    {
        return $this->data;
    }
}