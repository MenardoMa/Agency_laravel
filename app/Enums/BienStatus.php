<?php

namespace App\Enums;

enum BienStatus: string
{
    case Disponible = 'disponible';
    case Vendu = 'vendu';
    case Loue = 'loue';
}