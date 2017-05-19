<?php

namespace Voximplant\batch;


/**
 * Container for batch request which contains commands
 * Class BatchContainer
 * @package App\Services
 * @author Anton Schekoldin <aschekoldin@voximplant.com>
 */
class BatchContainer
{
    public $one_transaction = false;
    public $stop_on_error = false;
    public $commands = [];

    /**
     * Adding batch command to container
     * @param BatchCommand $command
     * @return BatchContainer
     */
    public function add(BatchCommand $command) : BatchContainer
    {
        $this->commands[] = $command;

        return $this;
    }

    /**
     * Setting in transaction
     */
    public function oneTransaction() : BatchContainer
    {
        $this->one_transaction = true;

        return $this;
    }

    /**
     * Stopping on error
     */
    public function stopOnError() : BatchContainer
    {
        $this->stop_on_error = true;

        return $this;
    }

    /**
     * Building array structure for request
     * @return array
     */
    public function build() : array
    {
        return (array)$this;
    }
}