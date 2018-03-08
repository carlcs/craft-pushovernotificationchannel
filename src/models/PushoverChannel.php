<?php

namespace carlcs\pushovernotificationchannel\models;

use carlcs\pushovernotificationchannel\exceptions\ServiceCommunicationError;
use rias\notifications\models\Notification;

class PushoverChannel
{
    /**
     * @var Pushover
     */
    protected $pushover;

    /**
     * Create a new Pushover channel instance.
     *
     * @param  Pushover $pushover
     */
    public function __construct(Pushover $pushover)
    {
        $this->pushover = $pushover;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \rias\notifications\models\Notification $notification
     *
     * @throws \carlcs\pushovernotificationchannel\exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (is_string($notifiable)) {
            $notifiable = PushoverReceiver::withUserKey($notifiable);
        }

        $message = $notification->toPushover($notifiable);

        try {
            $this->pushover->send(array_merge($message->toArray(), $notifiable->toArray()));
        } catch (ServiceCommunicationError $serviceCommunicationError) {
            // TODO: trigger notification failed event
        }
    }
}
