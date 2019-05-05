# Walletmix Sms Channel

#### Prerequisites
Before you can send notifications via **Walletmix**, you need to install the **yhshanto/walletmix-sms-channel** Composer package:

```composer require yhshanto/walletmix-sms-channel```

Next, you will need to add a few configuration options to your **config/services.php** configuration file. You may copy the example configuration below to get started:

```php
'walletmix' => [
  'sms' => [
    'username'  => env('WALLETMIX_SMS_USERNAME'),
    'password'  => env('WALLETMIX_SMS_PASSWORD'),
    'from' 		=> env('WALLETMIX_SMS_FROM') // SMS Mask
  ]
]
```

The **from** option is the phone number or mask that your SMS messages will be sent from. You can contact with Walletmix for more info.


#### Formatting SMS Notifications
If a notification supports being sent as an SMS, you should define a toWalletmix method on the notification class. This method will receive a $notifiable entity and should return a  **YHShanto\WalletmixSMS\Messages\WalletmixMessage** instance:
```php
/**
 * Get the Walletmix / SMS representation of the notification.
 *
 * @param  mixed  $notifiable
 * @return WalletmixMessage
 */
public function toWalletmix($notifiable)
{
    return (new WalletmixMessage)
                ->content('Your SMS message content');
}
```
##### Unicode Content
If your SMS message will contain unicode characters, you should call the unicode method when constructing the **WalletmixMessage** instance:

```php
/**
 * Get the Walletmix / SMS representation of the notification.
 *
 * @param  mixed  $notifiable
 * @return WalletmixMessage
 */
public function toWalletmix($notifiable)
{
    return (new WalletmixMessage)
                ->content('Your unicode message')
                ->unicode();
}
```
#### Customizing The "From" Number

If you would like to send some notifications from a **phone number/mask** that is different from the **phone number/mask** specified in your **config/services.php** file, you may use the from method on a **WalletmixMessage** instance:

```php
/**
 * Get the Walletmix / SMS representation of the notification.
 *
 * @param  mixed  $notifiable
 * @return WalletmixMessage
 */
public function toWalletmix($notifiable)
{
    return (new WalletmixMessage)
                ->content('Your SMS message content')
                ->from('15554443333');
}
```

#### Routing SMS Notifications

When sending notifications via the **walletmix** channel, the notification system will automatically look for a **phone** attribute on the notifiable entity. If you would like to customize the phone number the notification is delivered to, define a **routeNotificationForWalletmix** method on the entity:

```php
<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Route notifications for the Walletmix channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForWalletmix($notification)
    {
        return $this->phone;
    }
}
```
