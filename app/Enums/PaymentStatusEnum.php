<?php

namespace App\Enums;

enum PaymentStatusEnum: string
{
    case PAID = 'Pagado';
    case REFUNDED = 'Reembolsado';
    case CANCELLED = 'Cancelado';
    case FAILED = 'Fallido';
}
