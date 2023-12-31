<?php
namespace App\Helpers;

use App\Models\User;

class ARMailContents
{
    public static function approvedARSubject(): string
    {
        return "Authorised Representative Application";
    }

    public static function approvedARBody(User $ARUser, string $password): string
    {
        $link = config("app.front_end_url");

        if ($link) {
            $link = $link . '?email=' . $ARUser->email;
        }

        $company = $ARUser->institution->name ?? "a company";
        $regID = $ARUser->getRegID();

        return "<p>
                Please be informed that you have been selected as an Authorised Representative for the  $company.
                </p>
            
            <p>
                Your FMDQ unique identification number is <b>$regID</b> and your login details for the MROIS portal is given below:
                <br>
                Username: $ARUser->email <br>
                Password: $password 
            </p>
            
            <p>
                Please not that your ID would be required in future correspondence with FMDQ. We advise that you keep it safely.
            </p>";
    }

    public static function applicationMEGSubject(): string
    {
        return "Authorised Representative Application";
    }

    public static function applicationMEGBody(User $ARUser): string
    {

        $link = env("APP_FRONTEND_URL");

        $company = $ARUser->institution->name ?? "a company";
        $regID = $ARUser->getRegID();

        $message = "<p>
                Please be informed that there is a new Authorised Representative for $company.
            </p>
            
            <p>
                The AR details is given below:
                <br>
                Surname: $ARUser->last_name <br>
                First Name: $ARUser->first_name <br>
                Email: $ARUser->email <br>
                ID number: $regID 
            </p>";

        return $message;
    }



    public static function transferAuthoriserSubject(): string
    {
        return "Authorised Representative Transfer";
    }

    public static function transferAuthoriserBody(User $ARUser): string
    {
        $regID = $ARUser->getRegID();
        return "<p>
            Kindly login to the “MROIS portal” to approve the transfer of <b>$regID</b>
        </p>";
    }

    public static function changeStatusAuthoriserSubject(string $action): string
    {
        return "Authorised Representative $action";
    }

    public static function changeStatusAuthoriserBody(User $ARUser, string $action): string
    {
        $regID = $ARUser->getRegID();
        return "<p>
            Kindly login to the “MROIS portal” to approve/reject the <b>$action</b> of <b>$regID</b>
        </p>";
    }

    public static function updateAuthoriserSubject(): string
    {
        return "Authorised Representative Update";
    }

    public static function updateAuthoriserBody(User $ARUser): string
    {
        $regID = $ARUser->getRegID();
        return "<p>
            Kindly login to the “MROIS portal” to approve/reject the <bUpdate</b> of <b>$regID</b>
        </p>
        ";
    }


    public static function updatedMEGSubject(): string
    {
        return "Authorised Representative Update";
    }

    public static function updatedMEGBody(User $oldUserDetails, array $updateFields): string
    {
        $basicData = $oldUserDetails->getBasicData(true);
        $basicDataStr = prettifyJson($basicData);
        $updateFieldsStr = prettifyJson($updateFields);
        return "<p>
            This is to inform you of an AR update:
        </p>

        <p>
            Old record: <br>
            $basicDataStr
        </p>

        <p>
                Updated Fields: <br>
                $updateFieldsStr
        </p>
        ";
    }



    public static function deactivationMEGSubject(): string
    {
        return "Authorised Representative Deactivation";
    }

    public static function deactivationMEGBody(User $ARUser): string
    {

        $company = $ARUser->institution->name ?? "a company";
        $regID = $ARUser->getRegID();

        $message = "<p>
                Please be informed that an Authorised Representative for $company has been deactivated.
            </p>
            
            <p>
                The AR details is given below:
                <br>
                Surname: $ARUser->last_name <br>
                First Name: $ARUser->first_name <br>
                Email: $ARUser->email <br>
                ID number: $regID <br>
                Status: <b>Deactivated</b>
            </p>";

        return $message;
    }

    public static function activationMEGSubject(): string
    {
        return "Authorised Representative Re-activated";
    }

    public static function activationMEGBody(User $ARUser): string
    {

        $company = $ARUser->institution->name ?? "a company";
        $regID = $ARUser->getRegID();

        $message = "<p>
                Please be informed that an Authorised Representative for $company has been re-activated.
            </p>
            
            <p>
                The AR details is given below:
                <br>
                Surname: $ARUser->last_name <br>
                First Name: $ARUser->first_name <br>
                Email: $ARUser->email <br>
                ID number: $regID <br>
                Status: <b>Activated</b>
            </p>";

        return $message;
    }

    public static function transferDeclineRequesterSubject(): string
    {
        return "Authorised Representative Transfer Declined";
    }

    public static function transferDeclineRequesterBody(User $ARUser, $reason): string
    {
        $regID = $ARUser->getRegID();

        $message = "<p>
                Please be informed that the transfer of AR $regID was declined.
            </p>
            
            <p>
                Reason: $reason
            </p>";

        return $message;
    }


    public static function transferApprovedMEGSubject(): string
    {
        return "Authorised Representative Transfer";
    }

    public static function transferApprovedMEGBody(User $ARUser): string
    {
        $regID = $ARUser->getRegID();

        $message = "<p>
                Kindly login to the “MROIS portal” to approve a transferred Authorised Representative with AR ID $regID
            </p>";

        return $message;
    }
}