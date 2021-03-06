<?php

namespace App\Notifications;

use App\Models\Sponsor;
use App\Models\User;
use App\Notifications\Messages\MailMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemovedFromSponsor extends UserMembershipChanged
{
    public $sponsor;
    public $member;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Sponsor $sponsor, User $member, User $instigator)
    {
        parent::__construct($instigator);
        $this->sponsor = $sponsor;
        $this->member = $member;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('sponsors.show', $this->sponsor);

        return (new MailMessage($this, $notifiable))
                    ->subject(trans(static::baseMessageLocation().'.removed_from_sponsor', [
                        'name' => $this->instigator->getDisplayName(),
                        'sponsor' => $this->sponsor->display_name,
                    ]))
                    ->action(trans('messages.notifications.see_sponsor'), $url)
                    ;
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
            'name' => static::getName(),
            'sponsor_id' => $this->sponsor->id,
            'member_id' => $this->member->id,
            'instigator_id' => $this->instigator->id,
        ];
    }
}
