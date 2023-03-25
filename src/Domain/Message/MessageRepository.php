<?php

declare(strict_types=1);

namespace App\Domain\Message;

use App\Domain\Chat\Chat;
use App\Domain\User\User;

interface MessageRepository
{
    /**
     * @return Message[]
     */
    public function findAll(): array;

    /**
     * @param int $chatId
     * @return Message[]
     */
    public function findMessagesOfChat(int $chatId): array;

    /**
     * @param Chat $chat
     * @param User $from
     * @param string $text
     * @return Message
     */
    public function createMessage(Chat $chat, User $from, string $text): Message;

    /**
     * @param int[] $ids
     * @return Message[]
     */
    public function findByChatIds(array $ids): array;

    /**
     * @param int $id
     * @return Void
     */
    public function deleteMessage(int $id): Void;
}
