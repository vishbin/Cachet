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

use CachetHQ\Cachet\Events\IncidentHasReportedEvent;
use Illuminate\Contracts\Mail\MailQueue;
use Illuminate\Mail\Message;

class SendIncidentEmailNotificationHandler
{
    /**
     * The mailer instance.
     *
     * @var \Illuminate\Contracts\Mail\Mailer
     */
    protected $mailer;

    /**
     * Create a new send incident email notification handler.
     *
     * @param \Illuminate\Contracts\Mail\Mailer $mailer
     *
     * @return void
     */
    public function __construct(MailQueue $mailer, Subscriber $subscriber)
    {
        $this->mailer = $mailer;
        $this->subscriber = $subscriber;
    }

    /**
     * Handle the event.
     *
     * @param \CachetHQ\Cachet\Events\IncidentHasReportedEvent $event
     *
     * @return void
     */
    public function handle(IncidentHasReportedEvent $event)
    {
        foreach ($this->subscriber->all() as $subscriber) {
            $mail = [
                'email'   => $subscriber->email,
                'subject' => 'New incident reported.',
            ];

            $this->mailer->queue([
                'html' => 'emails.incidents.new-html',
                'text' => 'emails.incidents.new-text',
            ], $mail, function (Message $message) use ($mail) {
                $message->to($mail['email'])->subject($mail['subject']);
            });
        }
    }
}
