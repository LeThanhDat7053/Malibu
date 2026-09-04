<?php

namespace ArchiElite\NotificationPlus\Listeners;

use ArchiElite\NotificationPlus\Facades\NotificationPlus;
use Botble\Hotel\Events\BookingCreated;

class SendBookingCreatedNotification
{
    public function handle(BookingCreated $event): void
    {
        $booking = $event->booking;
        $address = $booking->address;
        $room = $booking->room;

        $lines = [];
        $lines[] = '🏨 *New Booking #' . $booking->booking_number . '*';

        if ($address && $address->name) {
            $lines[] = '👤 Guest: ' . $address->name;
        }

        if ($address && $address->email) {
            $lines[] = '📧 Email: ' . $address->email;
        }

        if ($address && $address->phone) {
            $lines[] = '📞 Phone: ' . $address->phone;
        }

        if ($room && $room->room) {
            $lines[] = '🛏 Room: ' . $room->room->name;
            $lines[] = '📅 Check-in: ' . ($room->start_date ? $room->start_date->format('d/m/Y') : '-');
            $lines[] = '📅 Check-out: ' . ($room->end_date ? $room->end_date->format('d/m/Y') : '-');
        }

        $lines[] = '💰 Amount: ' . number_format((float) $booking->amount, 2) . ' ' . ($booking->currency?->title ?? '');
        $lines[] = '🔖 Status: ' . $booking->status->label();

        $message = implode("\n", $lines);

        foreach (NotificationPlus::getAvailableDrivers() as $driverClass) {
            rescue(fn () => NotificationPlus::driver($driverClass)->send($message));
        }
    }
}
