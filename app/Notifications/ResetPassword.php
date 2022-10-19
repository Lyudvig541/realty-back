<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    public $token;
    public $email;

    public function __construct($token,$email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        if($this->email){
            return (new MailMessage)
                ->subject('Your Reset Password')
                ->line('You are receiving this email because we received a password reset request for your account.')
                ->action('Reset Password','https://1sq.realty/reset_password/'.$this->token.'/'. $this->email)
                ->line('If you did not request a password reset, no further action is required.');
        }
        return (new MailMessage)
            ->subject('Your Reset Password')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password','https://business.1sq.realty/password/reset/'.$this->token.'/'. $this->email)
            ->line('If you did not request a password reset, no further action is required.');
    }
}
