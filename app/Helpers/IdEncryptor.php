<?php
namespace App\Helpers;
class IdEncryptor
{
    private static $key = 'flUhRq6tzZclQEJ-Vdg-IuiaDsNc';

    public static function encode($id)
    {
        return urlencode(base64_encode(openssl_encrypt($id, 'AES-128-ECB', self::$key)));
    }

    public static function decode($encrypted)
    {
        return openssl_decrypt(base64_decode(urldecode($encrypted)), 'AES-128-ECB', self::$key);
    }

    // public static function encode(int $id): string
    // {
    //     // Ajouter la clé au début pour sécuriser
    //     $data = self::$key . ':' . $id;

    //     // Crypter avec base64
    //     $hash = base64_encode($data);

    //     // Enlever les caractères spéciaux
    //     $hash = preg_replace('/[^a-zA-Z0-9]/', '', $hash);

    //     // Limiter à 32 caractères et compléter si nécessaire
    //     $hash = str_pad(substr($hash, 0, 32), 32, 'X');

    //     // Formater en UUID-like (8-4-4-4-12)
    //     return substr($hash, 0, 8) . '-' .
    //            substr($hash, 8, 4) . '-' .
    //            substr($hash, 12, 4) . '-' .
    //            substr($hash, 16, 4) . '-' .
    //            substr($hash, 20, 12);
    // }

    // /**
    //  * Décode un ID depuis le format UUID-like.
    //  */
    // public static function decode(string $uuid): ?int
    // {
    //     // Retirer les tirets
    //     $hash = str_replace('-', '', $uuid);

    //     // Décoder la base64 inversée
    //     $raw = base64_decode($hash, true);

    //     if (!$raw || strpos($raw, self::$key . ':') !== 0) {
    //         return null; // Invalid or tampered
    //     }

    //     // Extraire l'ID original
    //     $parts = explode(':', $raw);
    //     return isset($parts[1]) ? (int)$parts[1] : null;
    // }

}
