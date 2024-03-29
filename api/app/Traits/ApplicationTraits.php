<?php

namespace App\Traits;

use App\Models\Application;
use App\Models\ApplicationFieldUpload;
use App\Models\Invoice;
use App\Models\ProofOfPayment;

trait ApplicationTraits
{
    public function subPaymentInformation($application_id)
    {
        $application = Application::find($application_id);
        $invoice = Invoice::find($application->invoice_id);

        return $invoice;
    }

    public function subLatestEvidence($application_id)
    {
        $application = Application::find($application_id);
        $proof = ProofOfPayment::find($application->proof_of_payment);

        return $proof;
    }

    public function subPaymentReviewDetails($application_id)
    {
        $application = Application::find($application_id);
        $invoice = Invoice::find($application->invoice_id);

        $concession = 0;
        $total = 0;

        if ($invoice) {
            $invoiceContents = $invoice->contents;

            if ($con = $invoice->contents()->where('name', 'Concession')->first()) {
                $concession = $con->value;
            }

            foreach ($invoiceContents as $invoiceContent) {
                if ($invoiceContent->name == 'Concession') {
                    continue;
                }
                if ($invoiceContent->type == 'credit') {
                    $total -= $invoiceContent->value;
                }

                if ($invoiceContent->type == 'debit') {
                    $total += $invoiceContent->value;
                }
            }
        }

        $payment_url = $application->invoiceToken ? route('invoice', ['uuid' => $application->invoiceToken]) : null;

        $data = [
            'concession_amount' => $concession,
            'concession_file' => $application->concession_file ? config('app.url') . '/storage/app/public/' . $application->concession_file : null,
            'total' => $total,
            'invoice_url' => $payment_url,
        ];

        return $data;

    }

    public function subRequiredDocuments($application_id)
    {

        $application_upload = ApplicationFieldUpload::where('application_id', $application_id)
            ->join('application_fields', 'application_fields.id', '=', 'application_field_uploads.application_field_id')
            ->where('application_fields.type', 'file')
            ->get();

        return $application_upload;
    }
}
