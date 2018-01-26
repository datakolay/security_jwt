<?php

require_once 'vendor/autoload.php';

use Namshi\JOSE\SimpleJWS;

class Security
{
    const PATH_CERTIFICATE_PRIVATE = "";
    const PATH_CERTIFICATE_PUBLIC = "";
    const SSL_KEY_PASSPHRASE = "";
    const TTL = 0; // seconds

    public static function createToken($payload = array())
    {
        $jws  = new SimpleJWS(array(
            'alg' => 'RS256'
        ));
        $claims = ['iat' => time()];

        if (null !== self::TTL) {
            $claims['exp'] = time() + self::TTL;
        }
        $jws->setPayload(array_merge($claims,$payload));

        $privateKey = openssl_pkey_get_private(file_get_contents(__DIR__.'/'.self::PATH_CERTIFICATE_PRIVATE), self::SSL_KEY_PASSPHRASE);
        $jws->sign($privateKey);

        return $jws->getTokenString();
    }

    public static function validateToken()
    {
        if (!array_key_exists("HTTP_AUTHORIZATION",$_SERVER)) {
            http_response_code(400);
            echo( json_encode(array("error" => "Restringed Area.")) );
            exit();
        }

        $jws        = SimpleJWS::load($_SERVER['HTTP_AUTHORIZATION']);
        $public_key = openssl_pkey_get_public(file_get_contents(__DIR__.'/'.self::PATH_CERTIFICATE_PUBLIC));

        if ($jws->isValid($public_key, 'RS256')) {
            $payload = $jws->getPayload();
            return $payload;
        } else {
            http_response_code(401);
            echo(json_encode(array("error" => "Invalid Token.")));
            exit();
        }
    }
}