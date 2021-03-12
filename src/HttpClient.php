<?php


namespace Eset\Api;


class HttpClient
{
    public function post($url, $headers, $httpBody)
    {
        $ch = curl_init( $url );
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => 1,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POSTFIELDS => $httpBody,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => $headers,
            CURLINFO_HEADER_OUT => true,
        ));

        $content = curl_exec( $ch );
        $err = curl_errno( $ch );
        $errmsg = curl_error( $ch );
        $header = curl_getinfo( $ch , CURLINFO_HEADER_OUT);
        $info = curl_getinfo($ch);
        curl_close( $ch );
        // var_dump($header);
        return $content;
    }
}