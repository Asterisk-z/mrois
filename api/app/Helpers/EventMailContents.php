<?php
namespace App\Helpers;

use App\Models\User;

class EventMailContents
{
    public static function paymentDeclinedARSubject(string $eventName): string
    {
        return "$eventName Payment Declined";
    }

    public static function paymentDeclinedARBody(string $eventName, string $reason): string
    {

        $message = "<p>
                Please be informed that your $eventName registration payment was declined.
            </p>
            <p>
                <b>Reason:</b> $reason
            </p>

            <p>
                Kindly contact Uju Iwuamadi +234 -1-2778771
            </p>";

        return $message;
    }


    public static function paymentApprovedARSubject(string $eventName): string
    {
        return "$eventName Payment Confirmation";
    }

    public static function paymentApprovedARBody(string $eventName, string $reason): string
    {

        $message = "<p>
                Please be informed that your $eventName registration payment has been approved.
            </p>";

        return $message;
    }


    public static function eventDeletedSubject(string $eventName): string
    {
        return "$eventName Has Been Cancelled";
    }

    public static function eventDeletedBody(string $eventName): string
    {

        $message = "<p>
                Please be informed that the event: $eventName has been cancelled.
            </p>";

        return $message;
    }


    public static function eventUpdatedSubject(string $eventName): string
    {
        return "$eventName Has Been Updated";
    }

    public static function eventUpdatedBody(string $eventName): string
    {

        $message = "<p>
                Please be informed that the event: $eventName has been updated. Kindly login to the “MROIS portal” to view the new details.
            </p>";

        return $message;
    }

    public static function eventAddedSubject(string $eventName): string
    {
        return "$eventName Has Been Added";
    }

    public static function eventAddedBody($event): string
    {

        $message = "<p>
                Please be informed that you have been invited for {$event->name} scheduled to hold {$event->date} {$event->time}. Kindly login to the MROIS Portal to register
            </p>";

        return $message;
    }

    public static function pendingPaymentForEventRegistrationSubject(string $eventName): string
    {
        return "$eventName Registration Fee Pending Approval";
    }

    public static function pendingPaymentForEventRegistrationBody(string $eventName): string
    {

        $message = "<p>
                Please be informed that there is a new registration for $eventName event fee pending approval.
            </p>";

        return $message;
    }
}