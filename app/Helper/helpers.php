<?php // Code within app\Helpers\Helper.php
namespace App\Helpers;
use Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;


class Helper
{
    public static function encodeID($str)
    {
        try {
            $encrypted = Crypt::encrypt($str);
            return $encrypted;

        } catch (\Exception $e) {
            abort(404);
        }

    }
    public static function decodeID($str)
    {
        try {
            $decrypted = Crypt::decrypt($str);
            return $decrypted;

        } catch (\Exception $e) {
            abort(404);
        }

    }
}