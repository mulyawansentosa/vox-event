<?php

namespace App;

use App\Mail\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class Functions{
    static function toRupiah($value,$decimal = 0){
        return (is_numeric($value)) ? "Rp. " . number_format($value,$decimal,',','.') : 0;
    }

    static function toInteger($value){
        return (int)$value;
    }

    static function sendEmail($data){
        return Mail::send(new Email($data));
    }

    static function exception($object)
    {
        return (is_object($object) && (
            get_class($object) == 'Exception' ||
            get_class($object) == 'Illuminate\Database\QueryException' ||
            get_class($object) == 'Illuminate\Auth\AuthenticationException' ||
            get_class($object) == 'Illuminate\Auth\Access\AuthorizationException' ||
            get_class($object) == 'Symfony\Component\HttpKernel\Exception\HttpException' ||
            get_class($object) == 'Illuminate\Database\Eloquent\ModelNotFoundException' ||
            get_class($object) == 'Illuminate\Validation\ValidationException' ||
            get_class($object) == 'ErrorException' ||
            get_class($object) == 'Error' ||
            get_class($object) == 'RelationNotFoundException'
            )
        ) ? true : false;
    }
}
