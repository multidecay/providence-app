<?php
namespace App\Enum;

enum TaskStateEnum:string
{
    case WTP = 'wait_to_pick';
    case Delivered = 'delivered';
    case Reported = 'reported';
}