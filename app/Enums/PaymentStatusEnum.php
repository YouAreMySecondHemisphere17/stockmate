<?php

namespace App\Enums;

enum PaymentStatusEnum: string
{
    case PENDING = 'Pendiente';
    case COMPLETED = 'Completado';
    case FAILED = 'Fallido';
    case CANCELLED = 'Cancelado';
}
