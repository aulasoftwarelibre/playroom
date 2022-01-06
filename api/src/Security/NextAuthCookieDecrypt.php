<?php

namespace App\Security;

use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Core\JWK;
use Jose\Component\Encryption\Algorithm\ContentEncryption\A256GCM;
use Jose\Component\Encryption\Algorithm\KeyEncryption\Dir;
use Jose\Component\Encryption\Compression\CompressionMethodManager;
use Jose\Component\Encryption\Compression\Deflate;
use Jose\Component\Encryption\JWE;
use Jose\Component\Encryption\JWEDecrypter;
use Jose\Component\Encryption\Serializer\CompactSerializer;
use Jose\Component\Encryption\Serializer\JWESerializerManager;
use Jose\Component\KeyManagement\JWKFactory;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

final class NextAuthCookieDecrypt
{
    private JWK $jwt;
    private JWEDecrypter $jweDecrypter;

    public function __construct(
        string $nextAuthSecret
    ) {
        $this->jwt = $this->generateJWT($nextAuthSecret);
        $this->jweDecrypter = $this->getJWEDecrypter();
    }

    public function decrypt(string $cookie): array
    {
        $jwe = $this->unserializeCookie($cookie);

        $success = $this->jweDecrypter->decryptUsingKey(
            $jwe,
            $this->jwt,
            0
        );

        if ($success === false) {
            throw new CustomUserMessageAuthenticationException("Error decoding token.");
        }

        return json_decode($jwe->getPayload(), true);
    }

    private function unserializeCookie(string $cookie): JWE
    {
        $serializerManager = new JWESerializerManager(
            [
            new CompactSerializer()
            ]
        );

        return $serializerManager->unserialize($cookie);
    }

    private function getJWEDecrypter(): JWEDecrypter
    {
        $keyEncryptionAlgorithmManager = new AlgorithmManager(
            [
            new Dir(),
            ]
        );
        $contentEncryptionAlgorithmManager = new AlgorithmManager(
            [
            new A256GCM(),
            ]
        );
        $compressionMethodManager = new CompressionMethodManager(
            [
            new Deflate(),
            ]
        );

        return new JWEDecrypter(
            $keyEncryptionAlgorithmManager,
            $contentEncryptionAlgorithmManager,
            $compressionMethodManager
        );
    }

    private function generateJWT(string $nextAuthSecret): JWK
    {
        $secret = hash_hkdf(
            "sha256",
            $nextAuthSecret,
            32,
            "NextAuth.js Generated Encryption Key",
            ""
        );

        return JWKFactory::createFromSecret(
            $secret,
            [
                'use' => 'enc',
                'alg' => 'A256GCM',
            ]
        );
    }
}
