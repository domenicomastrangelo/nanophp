<?php

namespace NanoPHP\Library;

class Encrypter
{
    // Available hash methods
    public const HASH_MD2         = "md2";
    public const HASH_MD4         = "md4";
    public const HASH_MD5         = "md5";
    public const HASH_SHA1        = "sha1";
    public const HASH_SHA224      = "sha224";
    public const HASH_SHA256      = "sha256";
    public const HASH_SHA384      = "sha384";
    public const HASH_SHA512      = "sha512";
    public const HASH_RIPEMD128   = "ripemd128";
    public const HASH_RIPEMD160   = "ripemd160";
    public const HASH_RIPEMD256   = "ripemd256";
    public const HASH_RIPEMD320   = "ripemd320";
    public const HASH_WHIRLPOOL   = "whirlpool";
    public const HASH_TIGER128_3  = "tiger128,3";
    public const HASH_TIGER160_3  = "tiger160,3";
    public const HASH_TIGER192_3  = "tiger192,3";
    public const HASH_TIGER128_4  = "tiger128,4";
    public const HASH_TIGER160_4  = "tiger160,4";
    public const HASH_TIGER192_4  = "tiger192,4";
    public const HASH_SNEFRU      = "snefru";
    public const HASH_SNEFRU256   = "snefru256";
    public const HASH_GOST        = "gost";
    public const HASH_GOST_CRYPTO = "gost-crypto";
    public const HASH_ADLER32     = "adler32";
    public const HASH_CRC32       = "crc32";
    public const HASH_CRC32B      = "crc32b";
    public const HASH_FNV132      = "fnv132";
    public const HASH_FNV1A32     = "fnv1a32";
    public const HASH_FNV164      = "fnv164";
    public const HASH_FNV1A64     = "fnv1a64";
    public const HASH_JOAAT       = "joaat";
    public const HASH_HAVAL128_3  = "haval128,3";
    public const HASH_HAVAL160_3  = "haval160,3";
    public const HASH_HAVAL192_3  = "haval192,3";
    public const HASH_HAVAL224_3  = "haval224,3";
    public const HASH_HAVAL256_3  = "haval256,3";
    public const HASH_HAVAL128_4  = "haval128,4";
    public const HASH_HAVAL160_4  = "haval160,4";
    public const HASH_HAVAL192_4  = "haval192,4";
    public const HASH_HAVAL224_4  = "haval224,4";
    public const HASH_HAVAL256_4  = "haval256,4";
    public const HASH_HAVAL128_5  = "haval128,5";
    public const HASH_HAVAL160_5  = "haval160,5";
    public const HASH_HAVAL192_5  = "haval192,5";
    public const HASH_HAVAL224_5  = "haval224,5";
    public const HASH_HAVAL256_5  = "haval256,5";

    // Available cryptographic algorithms

    public const CRYPT_AES_128_CBC  = "aes-128-cbc";
    public const CRYPT_AES_128_CFB  = "aes-128-cfb";
    public const CRYPT_AES_128_CFB1 = "aes-128-cfb1";
    public const CRYPT_AES_128_CFB8 = "aes-128-cfb8";
    public const CRYPT_AES_128_OFB  = "aes-128-ofb";
    public const CRYPT_AES_192_CBC  = "aes-192-cbc";
    public const CRYPT_AES_192_CFB  = "aes-192-cfb";
    public const CRYPT_AES_192_CFB1 = "aes-192-cfb1";
    public const CRYPT_AES_192_CFB8 = "aes-192-cfb8";
    public const CRYPT_AES_192_OFB  = "aes-192-ofb";
    public const CRYPT_AES_256_CBC  = "aes-256-cbc";
    public const CRYPT_AES_256_CFB  = "aes-256-cfb";
    public const CRYPT_AES_256_CFB1 = "aes-256-cfb1";
    public const CRYPT_AES_256_CFB8 = "aes-256-cfb8";
    public const CRYPT_AES_256_OFB  = "aes-256-ofb";
    public const CRYPT_BF_CBC       = "bf-cbc";
    public const CRYPT_BF_CFB       = "bf-cfb";
    public const CRYPT_BF_OFB       = "bf-ofb";
    public const CRYPT_CAST5_CBC    = "cast5-cbc";
    public const CRYPT_CAST5_CFB    = "cast5-cfb";
    public const CRYPT_CAST5_OFB    = "cast5-ofb";
    public const CRYPT_IDEA_CBC     = "idea-cbc";
    public const CRYPT_IDEA_CFB     = "idea-cfb";
    public const CRYPT_IDEA_OFB     = "idea-ofb";

    public function __construct()
    {
    }

    public static function hash(string $algo, string $data)
    {
        return hash($algo, $data, false);
    }

    public static function crypt(string $data, string $method, string $key, string $iv): string
    {
        return openssl_encrypt($data, $method, $key, 0, $iv);
    }

    public static function decrypt(string $data, string $method, string $key, string $iv): string
    {
        return openssl_decrypt($data, $method, $key, 1, $iv);
    }
}
