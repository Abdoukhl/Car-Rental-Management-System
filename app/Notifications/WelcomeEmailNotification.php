<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Notifications\Notification;


class WelcomeEmailNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail']; // إرسال الإشعار عبر البريد الإلكتروني
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('مرحبًا بك في تطبيقنا!')
                    ->greeting('مرحبًا ' . $notifiable->name . '!')
                    ->line('شكرًا لتسجيلك في تطبيقنا.')
                    ->line('نأمل أن تستمتع بتجربتك معنا.')
                    ->action('زيارة التطبيق', url('/'))
                    ->line('إذا كانت لديك أي أسئلة، فلا تتردد في التواصل معنا.');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}