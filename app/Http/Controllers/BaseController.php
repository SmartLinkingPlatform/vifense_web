<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Flysystem\AdapterInterface;
use phpDocumentor\Reflection\Types\Collection;
use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;
use Illuminate\Support\Str;
use SebastianBergmann\Invoker\Exception;

class BaseController extends Controller
{
    protected $dgt_db = "dgtdb";
    protected $cipher = "AES-128-CBC";//AES-128-CBC | AES-256-CBC
    protected $secret_key = 'dgtsplatformcypt';
    protected $secret_iv = 'dgtsplatformcypt';

    public function __construct(Request $request)
    {

    }

    public function encrypt ( $string )
    {
        $cipher = Str::of($this->cipher)->lower();
        $buffer = array();
        $pwd = '';
        try{
            if (in_array($cipher, openssl_get_cipher_methods()))
            {
                $pwd = openssl_encrypt($string, $cipher, $this->secret_key, 1, $this->secret_iv);
                for($i=0; $i<strlen($pwd); $i++) {
                    $buffer[$i] = ord($pwd[$i]);
                }
            }
        }catch (Exception $e){
        }

        return base64_encode($pwd);
    }
    public function decrypt ( $string )
    {
        $cipher = Str::of($this->cipher)->lower();
        $i_txt = base64_decode($string);
        $pwd = '';
        try{
            if (in_array($cipher, openssl_get_cipher_methods())){
                $pwd = openssl_decrypt($i_txt, $cipher, $this->secret_key, 1, $this->secret_iv);
            }
        }catch (Exception $e){
        }

        return $pwd;
    }

}
