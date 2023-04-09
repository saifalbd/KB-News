<?php

namespace App\Notifications;

use App\Channels\SMSChannel;
use App\Models\Task;
use App\Service\SMS;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAssigned extends Notification
{
    use Queueable;



    public Task $task;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database',SMSChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }



    public function toSms($notifiable){
        $task = $this->task;
        $assigner = $task->assigner;
        $employee = $task->employee->model;
        $title = $task->title;
        $assignerName = $assigner->name;
        $message = $assignerName.' '.'আপনাকে নতুন টাস্ক দিয়েছেন বিষয় : '.$title;

        return (new SMS)->number($employee->phone)->message($message);
    }





    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user_id'=>$this->task->user_id,
            'task_id' => $this->task->id,
            'message' => $this->task->title,

        ];
    }
}
