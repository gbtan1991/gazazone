<?php

namespace App\Actions;

use App\Enums\BookingStatus;
use App\Enums\PipelineStage;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Service;

class CreateBooking
{
    public function execute(
        string $customerName,
        ?string $customerEmail,
        ?string $customerPhone,
        string $serviceId,
        ?string $assignedTo,
        string $bookedAt,
        ?string $notes,
    ): Booking {
        $customer = Customer::firstOrCreate(
            ['email' => $customerEmail],
            [
                'name'           => $customerName,
                'phone'          => $customerPhone,
                'pipeline_stage' => PipelineStage::Lead,
            ],
        );

        // Update name/phone if existing customer had no email
        if (! $customer->wasRecentlyCreated && $customerEmail === null) {
            $customer = Customer::create([
                'name'           => $customerName,
                'phone'          => $customerPhone,
                'pipeline_stage' => PipelineStage::Lead,
            ]);
        }

        $service = Service::find($serviceId);

        return Booking::create([
            'customer_id'      => $customer->id,
            'service_id'       => $serviceId,
            'assigned_to'      => $assignedTo,
            'booked_at'        => $bookedAt,
            'duration_minutes' => $service?->duration_minutes ?? 60,
            'status'           => BookingStatus::Confirmed,
            'notes'            => $notes,
        ]);
    }
}
