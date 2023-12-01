<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Flysystem\AdapterInterface;
use phpDocumentor\Reflection\Types\Collection;
use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;

class BaseController extends Controller
{
    protected $dgt_db = "dgtdb";

    public function __construct(Request $request)
    {

    }

    function encrypt_decrypt($action, $string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = 'c4ca4238a0b923820dcc';
        $secret_iv = 'c4ca4238a0b923820dcc';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == 'decrypt' ) {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

}
