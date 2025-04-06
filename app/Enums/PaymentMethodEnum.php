<?php

namespace App\Enums;

enum PaymentMethodEnum: string
{
    case CASH = 'Efectivo';
    case CREDIT_CARD = 'Tarjeta';
    case BANK_TRANSFER = 'Transferencia';
    case ONLINE_PAYMENT = 'Pago en línea';
}
