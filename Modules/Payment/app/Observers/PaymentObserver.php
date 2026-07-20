<?php

namespace Modules\Payment\Observers;

use Illuminate\Support\Str;
use Modules\Payment\Models\Payment;

class PaymentObserver
{
    public function creating(Payment $payment): void
    {
        if (blank($payment->token)) {
            $payment->token = Str::uuid()->toString();
        }
    }
}
