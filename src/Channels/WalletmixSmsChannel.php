<?php
namespace YHShanto\WalletmixSMS\Channels;

use YHShanto\WalletmixSMS\Messages\WalletmixMessage;

class WalletmixSmsChannel
{
    /**
     * Walletmix Sms Credentials.
     *
     * @var string
     */
    protected $config;

    /**
     * Create a new Walletmix Sms channel instance.
     *
     * @param  array  $config
     * @param  string  $from
     * @return void
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return \YHShanto\WalletmixSMS\Message\Message
     */
    public function send($notifiable, $notification)
    {

        $to = $notifiable->routeNotificationFor('walletmix', $notification);
        $to = $to?$to:$notifiable->phone;
        
        if (! $to) {
            return;
        }

        $message = $notification->toWalletmix($notifiable);

        if (is_string($message)) {
            $message = new WalletmixMessage($message);
        }

        $from = $message->from ? $message->from : $this->config['from'];

        $url = sprintf(
            "http://sms.walletmix.biz/sms-api/apiAccess?username=%s&password=%s&type=%s&destination=%s&source=%s&message=%s",
                $this->config['username'],
                $this->config['password'],
                $message->type,
                $to,
                $from,
                urlencode($message->content)
            );
        return file_get_contents($url);
    }
}
