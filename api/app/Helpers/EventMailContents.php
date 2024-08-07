<?php
namespace App\Helpers;

class EventMailContents
{

    public static function certificateARSubject(string $eventName): string
    {
        return "$eventName Certificate";
    }

    public static function certificateARBody(string $eventName): string
    {

        $message = "<p>
                Please be find attached your certificate of participation for <b>$eventName</b>.
            </p>";

        return $message;
    }

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
               For further clarification, kindly contact Membership & Subscriptions Group on +234 20-1-700-8555
            </p>";
        //  Kindly contact Uju Iwuamadi +234 20-1-700-8555
        return $message;
    }

    public static function paymentApprovedARSubject(string $eventName): string
    {
        return "$eventName Payment Confirmation";
    }

    public static function paymentApprovedARBody(string $eventName): string
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
        $url = config('app.front_end_url');
        $message = "<p>
                Please be informed that the event: $eventName has been updated. Kindly login to the <a href='{$url}'>MROIS Portal</a> to view the new details.
            </p>";

        return $message;
    }

    public static function eventAddedSubject(string $eventName): string
    {
        return "Register for the $eventName Event";
    }

    public static function eventAddedBody($event): string
    {
        $url = config('app.front_end_url');
        $date = formatDate($event->date);
        $message = "<p>
                Please be informed that you have been invited for {$event->name} scheduled to hold {$date} {$event->time}. <br/> Kindly login to the <a href='{$url}'>MROIS Portal</a> to register.
            </p>";

        return $message;
    }

    public static function invitedSubject(string $eventName): string
    {
        return "Register for $eventName";
    }

    public static function invitedBody($event): string
    {
        $url = config('app.front_end_url');
        $date = formatDate($event->date);
        $message = "<p>
                Please be informed that you have been invited for {$event->name} scheduled to hold {$date} {$event->time}. Kindly login to the <a href='{$url}'>MROIS Portal</a> to register.
            </p>";

        return $message;
    }

    public static function reminderSubject(string $eventName): string
    {
        return "$eventName Reminder";
    }

    public static function reminderBody($event): string
    {

        $date = formatDate($event->date);
        $message = "<p>
                Trust this mail meets you well.
            </p>
            <p>
            We wish to remind you of the {$event->name} event scheduled {$date} {$event->time}.
            </p>
            <p>
            We look forward to your attendance.
            </p>";

        return $message;
    }

    public static function registerReminderSubject(string $eventName): string
    {
        return " Register for the $eventName Event";
    }

    public static function registerReminderBody($event): string
    {

        $url = config('app.front_end_url');
        $date = formatDate($event->date);
        $message = "<p>
                Please be informed that you are yet to register for the {$event->name} scheduled to hold on {$date} {$event->time}.
            </p>
            <p>
             Kindly login to the <a href='{$url}'>MROIS Portal</a> to register.
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

    public static function eventUninvitedSubject(string $eventName): string
    {
        return "Uninvited from $eventName";
    }

    public static function eventUninvitedBody(string $eventName): string
    {
        $message = "<p>
            You have been uninvited from $eventName event.
            </p>";

        return $message;
    }
}
