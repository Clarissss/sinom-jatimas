<?php

namespace App\Exceptions;

use RuntimeException;

class ChatEncryptionException extends RuntimeException
{
    public static function missingMasterKey(): self
    {
        return new static('Chat encryption master key is not configured.');
    }

    public static function encryptionFailed(string $reason): self
    {
        return new static("Message encryption failed: {$reason}");
    }

    public static function decryptionFailed(string $reason): self
    {
        return new static("Message decryption failed: {$reason}. Data may be corrupted or the key is incorrect.");
    }

    public static function invalidCiphertextFormat(): self
    {
        return new static('Invalid ciphertext format. Expected Base64 encoded nonce (12 bytes) + tag (16 bytes) + ciphertext.');
    }
}
