<?php

namespace Voximplant\batch;

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
     * @return array
     */
    public function get(int $index) : array
    {
        if (isset($this->data[$index]->result)) {
            return $this->data[$index]->result;
        }
        return $this->data[$index]->error;
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
}