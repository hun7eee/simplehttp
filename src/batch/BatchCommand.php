<?php

namespace Voximplant\batch;


/**
 * Batch command class which describes batch command format
 * Class BatchCommand
 * @package App\Services
 * @author Anton Schekoldin <aschekoldin@voximplant.com>
 */
class BatchCommand
{
    public $cmd;
    public $count;
    public $offset;

    public function __construct(string $cmd, array $params)
    {
        $this->cmd = $cmd;

        foreach ($params as $param => $value) {
            $this->$param = $value;
        }
    }

    public function offset(int $offset) : BatchCommand
    {
        $this->offset = $offset;
        return $this;
    }

    public function count(int $count) : BatchCommand
    {
        $this->count = $count;
        return $this;
    }
}