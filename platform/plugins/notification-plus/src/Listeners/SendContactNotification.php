<?php

namespace ArchiElite\NotificationPlus\Listeners;

use ArchiElite\NotificationPlus\Facades\NotificationPlus;
use Botble\Contact\Events\SentContactEvent;

class SendContactNotification
{
    public function handle(SentContactEvent $event): void
    {
        $contact = $event->data;

        if (! $contact) {
            return;
        }

        $lines = [];
        $lines[] = '📬 *New Contact Message*';
        $lines[] = '👤 Name: ' . $contact->name;

        if ($contact->email) {
            $lines[] = '📧 Email: ' . $contact->email;
        }

        if ($contact->phone) {
            $lines[] = '📞 Phone: ' . $contact->phone;
        }

        if ($contact->subject) {
            $lines[] = '📝 Subject: ' . $contact->subject;
        }

        if ($contact->content) {
            $lines[] = '💬 Message: ' . $contact->content;
        }

        $message = implode("\n", $lines);

        foreach (NotificationPlus::getAvailableDrivers() as $driverClass) {
            rescue(fn () => NotificationPlus::driver($driverClass)->send($message));
        }
    }
}
