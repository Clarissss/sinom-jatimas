<?php

namespace App\Casts;

use App\Exceptions\ChatEncryptionException;
use App\Services\ChatEncryptionService;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class EncryptedMessageCast implements CastsAttributes
{
    /**
     * Cast the given value to the encrypted string for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return string
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        if ($value === null) {
            return '';
        }

        $conversationId = $this->resolveConversationId($model, $attributes);

        if ($conversationId === null) {
            throw ChatEncryptionException::encryptionFailed(
                'Cannot encrypt message without a project_id or conversation_id context'
            );
        }

        return app(ChatEncryptionService::class)->encrypt((string) $value, $conversationId);
    }

    /**
     * Cast the given value from storage to the decrypted string.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return string|null
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        $conversationId = $this->resolveConversationId($model, $attributes);

        if ($conversationId === null) {
            Log::warning('Decryption skipped: missing project_id or conversation_id context', [
                'model_id' => $model->getKey(),
            ]);

            throw ChatEncryptionException::decryptionFailed(
                'Cannot decrypt message without a project_id or conversation_id context'
            );
        }

        return app(ChatEncryptionService::class)->decrypt((string) $value, $conversationId);
    }

    /**
     * Resolve the conversation identifier for key derivation.
     * Uses project_id if available, otherwise conversation_id.
     */
    private function resolveConversationId(Model $model, array $attributes): string|int|null
    {
        $projectId = $model->getAttribute('project_id')
            ?? $attributes['project_id']
            ?? null;

        if ($projectId !== null) {
            return $projectId;
        }

        $conversationId = $model->getAttribute('conversation_id')
            ?? $attributes['conversation_id']
            ?? null;

        if ($conversationId !== null) {
            return 'conv:' . $conversationId;
        }

        return null;
    }
}
