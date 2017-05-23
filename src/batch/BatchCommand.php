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

    public $account_id;
    public $session_id;

    public function __construct(string $cmd, int $account_id, int $session_id)
    {
        $this->cmd = $cmd;
        $this->account_id = $account_id;
        $this->session_id = $session_id;
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

    public function __call($name, $args)
    {
        $this->$name = $args[0];
    }
}