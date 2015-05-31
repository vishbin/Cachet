<?php

/*
 * This file is part of Cachet.
 *
 * (c) Cachet HQ <support@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Handlers\Events;

use CachetHQ\Cachet\Events\MaintenanceHasReportedEvent;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Mail\Message;

class SendMaintenanceEmailNotificationHandler implements ShouldBeQueued
{
    /**
     * The mailer instance.
     *
     * @var \Illuminate\Contracts\Mail\Mailer
     */
    protected $mailer;

    /**
     * Create a new send maintenance email notification handler.
     *
     * @param \Illuminate\Contracts\Mail\Mailer $mailer
     *
     * @return void
     */
    public function __construct(Mailer $mailer, Subscriber $subscriber)
    {
        $this->mailer = $mailer;
        $this->subscriber = $subscriber;
    }

    /**
     * Handle the maintenance has scheduled event.
     *
     * @param \CachetHQ\Cachet\Events\MaintenanceHasReportedEvent $event
     *
     * @return void
     */
    public function handle(MaintenanceHasReportedEvent $event)
    {
        $incident = $event->getIncident();

        foreach ($this->subscriber->all() as $subscriber) {
            $mail = [
                'email'   => $subscriber->email,
                'subject' => 'Scheduled maintenance.',
            ];

            $this->mailer->send([
                'html' => 'emails.incidents.maintenance-html',
                'text' => 'emails.incidents.maintenance-text',
            ], $mail, function (Message $message) use ($mail) {
                $message->to($mail['email'])->subject($mail['subject']);
            });
        }
    }
}
