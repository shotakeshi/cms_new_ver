<?php
namespace App\Enums;

enum ActivityAction: string
{
    case CREATE = 'create';
    case UPDATE = 'update';
    case DELETE = 'delete';
    case UPLOAD = 'upload';
    case LOGIN  = 'login';
    case LOGOUT = 'logout';
}