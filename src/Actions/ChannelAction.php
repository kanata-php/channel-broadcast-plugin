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
        $this->validateData($data);

        try {
            /**
             * Filter: channel_message
             * Description: Makes it possible for channel message processing before broadcasting.
             * Expected return: array
             * @param array $data
             * @param ?string $channel
             */
            $data['data'] = apply_filters(
                'channel_message',
                [$data['data'], $this->getCurrentChannel()]
            );
        } catch (Exception $e) {
            logger()->error('Channel message broadcast failed: ' . $e->getMessage());

        }

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
        /**
         * Filter: channel_message_valid
         * Description: Makes it possible for channel validation customization.
         * Expected return: bool
         * @param bool $valid
         * @param array $data
         * @param ?string $channel
         */
        $valid = apply_filters(
            'channel_message_valid',
            [true, $data, $this->getCurrentChannel()]
        );

        if (!$valid) {
            throw new InvalidArgumentException('Data was invalid.');
        }
    }
}
