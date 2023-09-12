<?php
namespace App\Enum;

enum ReportTypeEnum:string
{
    case Socket = 'socket';
    case Text = 'text';
    case File = 'file';
    case Failure = 'failure';
}