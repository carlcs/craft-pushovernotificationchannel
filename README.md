# Pushover Notification Channel plugin for Craft Notifications

A Pushover notification channel for the [Craft Notifications](https://github.com/rias500/craft-notifications) plugin

## Requirements

The plugin requires Craft CMS 3.0 or later, and the Craft Notifications plugin.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

```
cd /path/to/project
```

2. Then tell Composer to load the plugin:

```
composer require carlcs/craft-pushovernotificationchannel
```

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Pushover Notification Channel.

## Usage

To configure a notification to be sent via Pushover, make sure your `via()` method on the Notification class returns a key with `pushover`.

```php
<?php
namespace app\notifications;

use carlcs\pushovernotificationchannel\models\PushoverMessage;
use carlcs\pushovernotificationchannel\models\PushoverReceiver;
use rias\notifications\models\Notification;

class ElementSaved extends Notification
{
    public function via()
    {
        return [
            'pushover' => '<PUSHOVER_USER_OR_GROUP_KEY>',
        ];
    }

    public function toPushover($notifiable)
    {
        $element = $this->event->sender;

        return PushoverMessage::create("Element saved {$element->title}")
            ->sound('incoming')
            ->lowPriority()
            ->url($element->getUrl(), 'Go to element page');
    }
}
```

The `pushover` value in the `via()` method can also be a `PushoverReceiver` object.
This allows to specify devices, or to overrule the API Token set in the plugin settings.

```php
return [
    'pushover' => PushoverReceiver::withUserKey('<PUSHOVER_USER_OR_GROUP_KEY>')
        ->toDevice('iphone')
        ->withApplicationToken('<PUSHOVER_API_TOKEN>');,
];
```

## Credits

[Laravel Notifications Channel - Pushover](https://github.com/laravel-notification-channels/pushover)
