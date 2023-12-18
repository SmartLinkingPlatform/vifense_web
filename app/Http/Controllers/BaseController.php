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
    protected $encrypt_method = "AES-256-CBC";
    protected $secret_key = 'dgtsplatformcypt';
    protected $secret_iv = 'dgtsplatformcypt';

    public function __construct(Request $request)
    {

    }

    function encrypt_decrypt($action, $string) {
        $output = false;
        // hash
        $key = hash('sha256', $this->secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $this->secret_iv), 0, 16);

        if ( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $this->encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == 'decrypt' ) {
            $output = openssl_decrypt(base64_decode($string), $this->encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    public function encrypt ( $string )
    {
        $sss = openssl_encrypt ( $string, $this->encrypt_method, $this->secret_key, 0,  $this->secret_iv  );
        if ( $encrypted = base64_encode ( $sss ) )
            //if ( $encrypted = base64_encode ( openssl_encrypt ( $string, $encrypt_method, $secret_key, 0, $secret_iv ) ) )
        {
            return $encrypted;
        }
        else
        {
            return false;
        }
    }
    public function decrypt ( $string )
    {
        if ( $decrypted = openssl_decrypt ( base64_decode ( $string ), $this->encrypt_method, $this->secret_key, 0, $this->secret_iv ) )
        {
            return $decrypted;
        }
        else
        {
            return false;
        }
    }


}
