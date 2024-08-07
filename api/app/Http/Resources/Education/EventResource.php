<?php

namespace App\Http\Resources\Education;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'date' => $this->date,
            'time' => $this->time,
            'is_annual' => $this->is_annual,
            'fee' => $this->fee > 1 ? number_format($this->fee, 2) : 0,

            'registered_remainder_frequency' => $this->registered_remainder_frequency,
            'unregistered_remainder_frequency' => $this->unregistered_remainder_frequency,

            'image' => $this->image,
            'image_url' => $this->image ? config('app.url') . '/storage/app/public/' . $this->image : null, // Adjust the path based on your storage setup
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'created_by' => ($this->createdBy != null) ? $this->createdBy->getBasicData() : null,

            'registered_remainder_dates' => $this->registeredRemainderDates,
            'unregistered_remainder_dates' => $this->unregisteredRemainderDates,
            'invited_positions' => $this->invitePosition,
            'registrations_count' => $this->registrations_count,

            'preview_certificate' => route('previewCertificate', $this->id),

            'is_event_completed' => $this->is_event_completed,
            'is_sent_for_signing' => $this->is_sent_for_signing,
            'cert_signature' => $this->cert_signature ? config('app.url') . '/storage/app/public/' . $this->cert_signature : null,
            'signed_by' => $this->signed_by,

        ];
    }
}
