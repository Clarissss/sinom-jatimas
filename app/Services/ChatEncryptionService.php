<?php

namespace App\Services;

use App\Exceptions\ChatEncryptionException;
use Illuminate\Support\Facades\Log;

class ChatEncryptionService
{
    private const CIPHER = 'aes-256-gcm';
    private const NONCE_LENGTH = 12; // 96-bit IV for GCM
    private const TAG_LENGTH = 16;   // 128-bit authentication tag
    private const KEY_LENGTH = 32;   // 256-bit key 

    private readonly string $masterKey;

    public function __construct()
    {
        $key = config('chat.encryption.master_key');

        if (empty($key)) {
            throw ChatEncryptionException::missingMasterKey();
        }

        $decoded = base64_decode($key, true);

        // Support both base64-encoded and raw keys
        $this->masterKey = $decoded !== false && strlen($decoded) >= self::KEY_LENGTH
            ? $decoded
            : $key;
    }

    /**
     * Derive a per-conversation key using HKDF-SHA256.
     *
     * @param string|int $conversationId Project ID or conversation identifier
     */
    public function deriveKey(string|int $conversationId): string
    {
        $info = 'conversation:' . $conversationId;

        $derived = hash_hkdf('sha256', $this->masterKey, self::KEY_LENGTH, $info);

        if ($derived === false || strlen($derived) !== self::KEY_LENGTH) {
            throw ChatEncryptionException::encryptionFailed('HKDF key derivation failed');
        }

        return $derived;
    }

    /**
     * Encrypt plaintext using AES-256-GCM with a random nonce.
     *
     * Format stored: base64(nonce + tag + ciphertext)
     *
     * @param string $plaintext The message content
     * @param string|int $conversationId The conversation/project identifier for key derivation
     */
    public function encrypt(string $plaintext, string|int $conversationId): string
    {
        $key = $this->deriveKey($conversationId);

        $nonce = random_bytes(self::NONCE_LENGTH);

        $tag = '';
        $ciphertext = openssl_encrypt(
            $plaintext,
            self::CIPHER,
            $key,
            OPENSSL_RAW_DATA,
            $nonce,
            $tag,
            '',
            self::TAG_LENGTH
        );

        if ($ciphertext === false) {
            throw ChatEncryptionException::encryptionFailed(openssl_error_string() ?: 'Unknown OpenSSL error');
        }

        // Ensure tag is exactly TAG_LENGTH bytes
        if (strlen($tag) !== self::TAG_LENGTH) {
            throw ChatEncryptionException::encryptionFailed('Authentication tag length mismatch');
        }

        // Format: nonce (12) + tag (16) + ciphertext
        $payload = $nonce . $tag . $ciphertext;

        return base64_encode($payload);
    }

    /**
     * Decrypt ciphertext using AES-256-GCM.
     *
     * @param string $encoded Base64 encoded payload: nonce + tag + ciphertext
     * @param string|int $conversationId The conversation/project identifier for key derivation
     */
    public function decrypt(string $encoded, string|int $conversationId): string
    {
        $payload = base64_decode($encoded, true);

        if ($payload === false) {
            throw ChatEncryptionException::invalidCiphertextFormat();
        }

        $minLength = self::NONCE_LENGTH + self::TAG_LENGTH + 1;

        if (strlen($payload) < $minLength) {
            throw ChatEncryptionException::invalidCiphertextFormat();
        }

        $nonce = substr($payload, 0, self::NONCE_LENGTH);
        $tag = substr($payload, self::NONCE_LENGTH, self::TAG_LENGTH);
        $ciphertext = substr($payload, self::NONCE_LENGTH + self::TAG_LENGTH);

        $key = $this->deriveKey($conversationId);

        $plaintext = openssl_decrypt(
            $ciphertext,
            self::CIPHER,
            $key,
            OPENSSL_RAW_DATA,
            $nonce,
            $tag
        );

        if ($plaintext === false) {
            Log::warning('Chat message decryption failed', [
                'conversation_id' => $conversationId,
                'error' => openssl_error_string(),
            ]);

            throw ChatEncryptionException::decryptionFailed('Authentication tag verification failed');
        }

        return $plaintext;
    }

    /**
     * Derive a key for archive operations.
     */
    public function deriveArchiveKey(string|int $conversationId, string $dateSuffix): string
    {
        $info = 'archive:' . $conversationId . ':' . $dateSuffix;

        $derived = hash_hkdf('sha256', $this->masterKey, self::KEY_LENGTH, $info);

        if ($derived === false || strlen($derived) !== self::KEY_LENGTH) {
            throw ChatEncryptionException::encryptionFailed('HKDF archive key derivation failed');
        }

        return $derived;
    }

    /**
     * Encrypt binary data (for archive files).
     *
     * Returns raw binary: nonce (12) + tag (16) + ciphertext
     */
    public function encryptBinary(string $data, string $key): string
    {
        $nonce = random_bytes(self::NONCE_LENGTH);

        $tag = '';
        $ciphertext = openssl_encrypt(
            $data,
            self::CIPHER,
            $key,
            OPENSSL_RAW_DATA,
            $nonce,
            $tag,
            '',
            self::TAG_LENGTH
        );

        if ($ciphertext === false) {
            throw ChatEncryptionException::encryptionFailed(openssl_error_string() ?: 'Unknown OpenSSL error');
        }

        return $nonce . $tag . $ciphertext;
    }

    /**
     * Decrypt binary data (for archive files).
     *
     * Expects raw binary: nonce (12) + tag (16) + ciphertext
     */
    public function decryptBinary(string $data, string $key): string
    {
        $minLength = self::NONCE_LENGTH + self::TAG_LENGTH + 1;

        if (strlen($data) < $minLength) {
            throw ChatEncryptionException::invalidCiphertextFormat();
        }

        $nonce = substr($data, 0, self::NONCE_LENGTH);
        $tag = substr($data, self::NONCE_LENGTH, self::TAG_LENGTH);
        $ciphertext = substr($data, self::NONCE_LENGTH + self::TAG_LENGTH);

        $plaintext = openssl_decrypt(
            $ciphertext,
            self::CIPHER,
            $key,
            OPENSSL_RAW_DATA,
            $nonce,
            $tag
        );

        if ($plaintext === false) {
            throw ChatEncryptionException::decryptionFailed('Archive decryption failed: authentication tag verification failed');
        }

        return $plaintext;
    }
}
