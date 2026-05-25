<?php

namespace Tests\Unit;

use App\Exceptions\ChatEncryptionException;
use App\Services\ChatEncryptionService;
use Tests\TestCase;

class ChatEncryptionServiceTest extends TestCase
{
    private ChatEncryptionService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(ChatEncryptionService::class);
    }

    public function test_encrypt_and_decrypt_roundtrip(): void
    {
        $plain = 'Hello, this is a secret message!';
        $conversationId = 42;

        $encrypted = $this->service->encrypt($plain, $conversationId);
        $decrypted = $this->service->decrypt($encrypted, $conversationId);

        $this->assertNotSame($plain, $encrypted);
        $this->assertSame($plain, $decrypted);
    }

    public function test_encrypted_payload_is_base64(): void
    {
        $encrypted = $this->service->encrypt('test', 1);
        $decoded = base64_decode($encrypted, true);

        $this->assertNotFalse($decoded);
        // nonce (12) + tag (16) + ciphertext (>=1)
        $this->assertGreaterThanOrEqual(29, strlen($decoded));
    }

    public function test_different_conversations_produce_different_ciphertexts(): void
    {
        $plain = 'Same plain text';

        $enc1 = $this->service->encrypt($plain, 1);
        $enc2 = $this->service->encrypt($plain, 2);

        $this->assertNotSame($enc1, $enc2);
    }

    public function test_same_conversation_produces_different_ciphertexts_due_to_nonce(): void
    {
        $plain = 'Same plain text';
        $conversationId = 99;

        $enc1 = $this->service->encrypt($plain, $conversationId);
        $enc2 = $this->service->encrypt($plain, $conversationId);

        $this->assertNotSame($enc1, $enc2);
    }

    public function test_corrupted_ciphertext_throws_exception(): void
    {
        $encrypted = $this->service->encrypt('test', 1);
        $corrupted = substr($encrypted, 0, 10) . 'X' . substr($encrypted, 11);

        $this->expectException(ChatEncryptionException::class);
        $this->expectExceptionMessage('Authentication tag verification failed');

        $this->service->decrypt($corrupted, 1);
    }

    public function test_wrong_conversation_key_throws_exception(): void
    {
        $encrypted = $this->service->encrypt('test', 1);

        $this->expectException(ChatEncryptionException::class);

        $this->service->decrypt($encrypted, 999);
    }

    public function test_archive_encrypt_decrypt_binary(): void
    {
        $data = 'Binary data for archive: ' . random_bytes(32);
        $key = $this->service->deriveArchiveKey(10, '20250101_120000');

        $encrypted = $this->service->encryptBinary($data, $key);
        $decrypted = $this->service->decryptBinary($encrypted, $key);

        $this->assertSame($data, $decrypted);
    }
}
