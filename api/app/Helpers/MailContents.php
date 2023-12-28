<?php

namespace App\Helpers;

class MailContents
{
    public static function signupMailSubject(): string
    {
        return "Registration Successful";
    }

    public static function signupMail($email, $date): string
    {
        return "<p>Your account has been successfully created. Below are your login details:</p>

        <ul>
            <li><strong>Username:</strong> {$email}</li>
            <li><strong>Account Creation Date:</strong> {$date}</li>
        </ul>";
    }

    public static function complaintSubmitSubject(): string
    {
        return "New Complaint Logged";
    }

    public static function complaintSubmitMail($name, $institution, $body): string
    {
        return "<p>You have a new complaint, details below:</p>

        <ul>
            <li><strong>Name:</strong> {$name}</li>
            <li><strong>Institution:</strong> {$institution}</li>
            <li><strong>Body:</strong> {$body}</li>
        </ul>";
    }

    public static function complaintCommentSubject(): string
    {
        return "New Comment on Complaint";
    }

    public static function complaintCommentMail($comment, $status): string
    {
        return "<p>You have a new comment on the complaint you made:</p>

        <ul>
            <li><strong>Status:</strong> {$status}</li>
            <li><strong>Comment:</strong> {$comment}</li>
        </ul>";
    }

    public static function complaintStatusSubject(): string
    {
        return "Complaint Status update";
    }

    public static function complaintStatusMail($status): string
    {
        return "<p>The status of a complaint you logged has just been updated:</p>

        <ul>
            <li><strong>Status:</strong> {$status}</li>
        </ul>";
    }

    public static function newMembershipSignupSubject(): string
    {
        return "New Membership Signup";
    }

    public static function newMembershipSignupMail($name, $category): string
    {
        return "<p>A new applicant has successfully signed up on the MROIS portal:</p>

        <ul>
            <li><strong>Name:</strong> {$name}</li>
            <li><strong>Category:</strong> {$category}</li>
        </ul>";
    }

    public static function newBroadcastMessageSubject(): string
    {
        return "New Broadcast Message";
    }

    public static function newBroadcastMessage($title, $content, $file = NULL): string
    {
        return "<p>There is a new message from the MROIS portal:</p>

        <ul>
            <li><strong>Title:</strong> {$title}</li>
            <p><strong>{$content}</strong></p>
        </ul>";
    }

    public static function newSanctionMessageSubject(): string
    {
        return "New Disciplinary and Sanctions Message";
    }

    public static function newSanctionMessage($ar_name, $ar_summary, $sanction_summary): string
    {
        return "<p>There is a new message from the MROIS portal:</p>

        <ul>
            <li><strong>AR:</strong> {$ar_name}</li>
            <li>AR Summary<strong>{$ar_summary}</strong></li>
            <li>Sanction Summary<strong>{$sanction_summary}</strong></li>
        </ul>";
    }
}
