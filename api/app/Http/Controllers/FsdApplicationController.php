<?php

namespace App\Http\Controllers;

use App\Helpers\MailContents;
use App\Helpers\Utility;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\Invoice;
use App\Models\Role;
use App\Models\User;
use App\Notifications\InfoNotification;
use App\Traits\ApplicationTraits;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;

class FsdApplicationController extends Controller
{
    use ApplicationTraits;
    /**
     * get institutions that are due for FSD review
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function institutions(Request $request)
    {
        $data = Application::where([
            'concession_stage' => true,
            'office_to_perform_next_action' => Application::office['FSD'],
        ])
            ->whereNotNull('proof_of_payment');

        $data = Utility::applicationDetails($data);
        $data = $data->get();

        return successResponse("Here you go", ApplicationResource::collection($data));
    }

    public function paymentInformation(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
        ]);

        $data = $this->subPaymentInformation($request->application_id);

        return successResponse("Here you go", $data ?? []);
    }

    public function latestEvidence(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
        ]);

        $data = $this->subLatestEvidence($request->application_id);
        return successResponse("Here you go", $data ?? []);
    }

    public function paymentReviewDetails(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
        ]);

        $data = $this->subPaymentReviewDetails($request->application_id);
        return successResponse("Here you go", $data ?? []);
    }

    public function fsdReview(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
            'status' => 'required|in:decline,approve',
            'comment' => 'required|string',
            'amount_received' => 'required_if:status,approve',
        ]);

        $user = $request->user();
        $application = Application::find($request->application_id);
        $invoice = Invoice::find($application->invoice_id);

        $errorMsg = "Unable to complete your request at this point.";
        if ($application->office_to_perform_next_action != Application::office['FSD']) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        if ($application->currentStatus() != Application::statuses['MDFR'] &&
            $application->currentStatus() != Application::statuses['PPU']) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        $applicant = User::find($application->submitted_by);
        $membershipCategory = $application->membershipCategory;
        $name = $applicant->first_name . ' ' . $applicant->last_name;

        $data = Application::where('applications.id', $request->application_id);
        $data = Utility::applicationDetails($data);
        $data = $data->first();

        if ($request->status == 'decline') {
            //SEND FIRST BATCH OF EMAIL
            $companyEmail = $data->company_email;
            $contactEmail = $data->primary_contact_email;

            $categoryName = $membershipCategory->name;

            $emailData = [
                'name' => $name,
                'subject' => 'Membership Application Payment Declined',
                'content' => "Please be informed that your payment as a {$categoryName} was declined.
                        <p>Reason: {$request->comment}</p>
                        <p>Kindly contact Uju Iwuamadi +234 -1-2778771</p>",
            ];

            // Recipient email addresses
            $toEmails = [$applicant->email, $companyEmail, $contactEmail];

            // CC email addresses
            $Meg = Utility::getUsersEmailByCategory(Role::MEG);
            $Mbg = Utility::getUsersEmailByCategory(Role::MBG);
            $fsd = Utility::getUsersEmailByCategory(Role::FSD);
            $ccEmails = array_merge($Meg, $Mbg, $fsd);

            Utility::emailHelper($emailData, $toEmails, $ccEmails);
            Utility::applicationStatusHelper($application, Application::statuses['FDP'], Application::office['FSD'], Application::office['AP'], $request->comment);
            $application->proof_of_payment = null;
            $application->save();
            logAction($user->email, 'FSD Declined', "FSD Declined an Applicant payment details.", $request->ip());
        }

        if ($request->status == 'approve') {
            Utility::applicationStatusHelper($application, Application::statuses['FAP'], Application::office['FSD'], Application::office['MBG'], $request->comment);
            $application->amount_received_by_fsd = $request->amount_received;
            $application->fsd_review_stage = 1;
            $application->save();

            $invoice->date_paid = Carbon::now()->format('Y-m-d');
            $invoice->is_paid = 1;
            $invoice->save();

            $MBGs = Utility::getUsersByCategory(Role::MBG);
            $MEGs = Utility::getUsersEmailByCategory(Role::MEG);
            $FSDs = Utility::getUsersEmailByCategory(Role::FSD);
            $CCs = array_merge($FSDs, $MEGs);
            Notification::send($MBGs, new InfoNotification(MailContents::approvedPaymentMail($applicant), MailContents::approvedPaymentSubject(), $CCs));
            logAction($user->email, 'FSD Approved', "FSD has approved applicant payment", $request->ip());
        }

        return successResponse("Application Updated Successfully");
    }
}
