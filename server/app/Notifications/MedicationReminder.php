<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Dose;

class MedicationReminder extends Notification
{
    use Queueable;

    protected $dose;

    /**
     * Create a new notification instance.
     */
    public function __construct(Dose $dose)
    {
        $this->dose = $dose;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // For now, we use 'log' to simulate WhatsApp sending
        // In production, you would add 'twilio' or custom channel here
        return ['log'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the log representation of the notification (Simulating WhatsApp).
     */
    public function toLog(object $notifiable)
    {
        $medicineName = $this->dose->medicine->name;
        $time = $this->dose->scheduled_time->format('H:i');
        $userName = $notifiable->name;
        $phone = $notifiable->phone;

        return [
            'channel' => 'whatsapp',
            'phone' => $phone,
            'message' => "مرحباً $userName 👋، حان موعد دواءك: *$medicineName* 💊 الساعة $time. نرجو الالتزام بالموعد ونتمنى لك السلامة! ❤️",
        ];
    }
}
