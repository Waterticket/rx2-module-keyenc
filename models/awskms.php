<?php

namespace Rhymix\Modules\Keyenc\Models;

/**
 * 키 암호화/복보화 모듈
 * 
 * Copyright (c) Waterticket
 * 
 * Generated with https://www.poesis.org/tools/modulegen/
 */
class AWSKMS
{
    protected static $KmsClient = null;

    public static function getKmsClient()
    {
        if(!self::$KmsClient)
        {
            self::$KmsClient = new \Aws\Kms\KmsClient([
                'profile' => 'default',
                'version' => '2014-11-01',
                'region'  => 'ap-northeast-2'
            ]);
        }

        return self::$KmsClient;
    }

    public static function EncryptShort($keyId, $message)
    {
        $KmsClient = self::getKmsClient();

        $result = $KmsClient->encrypt([
            'KeyId' => $keyId, 
            'Plaintext' => $message, 
        ]);
        
        return base64_encode($result['CiphertextBlob']);
    }

    public static function DecryptShort($keyId, $ciphertext)
    {
        $KmsClient = self::getKmsClient();

        $result = $KmsClient->decrypt([
            'CiphertextBlob' => base64_decode($ciphertext),
            'KeyId' => $keyId,
       ]);
       
       return $result['Plaintext'];
    }
}
