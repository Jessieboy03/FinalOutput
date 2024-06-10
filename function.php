<?php
function calculateAmortization($principal, $rate, $term) {
    $monthly_rate = $rate / 100 / 12;
    $monthly_payment = $principal * $monthly_rate / (1 - pow(1 + $monthly_rate, -$term));

    $schedule = [];
    for ($month = 1; $month <= $term; $month++) {
        $interest = $principal * $monthly_rate;
        $principal_payment = $monthly_payment - $interest;
        $principal -= $principal_payment;

        $schedule[] = [
            'month' => $month,
            'payment' => $monthly_payment,
            'principal' => $principal_payment,
            'interest' => $interest,
            'balance' => $principal
        ];
    }
    return $schedule;
}
?>
