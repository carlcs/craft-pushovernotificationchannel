<?php

namespace carlcs\pushovernotificationchannel;

use carlcs\pushovernotificationchannel\models\Pushover;
use carlcs\pushovernotificationchannel\models\PushoverChannel;
use carlcs\pushovernotificationchannel\models\Settings;
use Craft;
use GuzzleHttp\Client as HttpClient;
use rias\notifications\events\RegisterChannelsEvent;
use rias\notifications\services\NotificationsService;
use yii\base\Event;

class Plugin extends \craft\base\Plugin
{
    /**
     * @inheritdoc
     */
    public $hasCpSettings = true;

    /**
     * @inheritdoc
     */
    public function init()
    {
        Event::on(NotificationsService::class, NotificationsService::EVENT_REGISTER_CHANNELS, function(RegisterChannelsEvent $event) {
            $event->channels['pushover'] = function() {
                return new PushoverChannel(new Pushover(new HttpClient(), $this->getSettings()->token));
            };
        });
    }

    /**
     * @inheritdoc
     */
    protected function createSettingsModel(): Settings
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        // Get and pre-validate the settings
        $settings = $this->getSettings();
        $settings->validate();

        // Get the settings that are being defined by the config file
        $overrides = Craft::$app->getConfig()->getConfigFromFile(strtolower($this->handle));

        return Craft::$app->getView()->renderTemplate('pushover-notification-channel/_settings', [
            'settings' => $settings,
            'overrides' => array_keys($overrides),
        ]);
    }
}
