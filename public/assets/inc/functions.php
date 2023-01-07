<?php

function generateIBAN(array $users, string $IBAN = ''): string
{
    $IBAN = 'LT' . rand(0, 9) . rand(0, 9) . ' ' . '0014' . ' ' . '7' . rand(0, 9) . rand(0, 9) . rand(0, 9) . ' ' . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . ' ' . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
    foreach ($users as $user) {
        if ($user['iban'] === $IBAN) {
            generateIBAN($users, $IBAN);
        }
    }
    return $IBAN;
}
