<?php

namespace ChannelBroadcast\Actions;

use Conveyor\Actions\Abstractions\AbstractAction;
use Exception;
use InvalidArgumentException;

class ChannelAction extends AbstractAction
{
    protected string $name = 'channel-action';

    /**
     * @param array $data
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function execute(array $data): mixed
    {
        /** @throws InvalidArgumentException */
        // $this->validateData($data['params']);
        $this->send($data['data'], null, true);
        return null;
    }

    /**
     * @param array $data
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function validateData(array $data) : void
    {
        // if (!isset($data['param'])) {
        //     throw new InvalidArgumentException('');
        // }
    }
}
