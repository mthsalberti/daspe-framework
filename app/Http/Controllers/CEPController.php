<?php
namespace Daspeweb\Framework\Controller;

use App\Http\Controllers\Controller;

class CEPController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function searchCEP($cep){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, false);
        $url = 'http://viacep.com.br/ws/' . $cep . '/json/';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSLVERSION,3);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
