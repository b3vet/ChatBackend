<?php

declare(strict_types=1);

namespace App\Domain\Chat;

use App\Domain\User\User;

interface ChatRepository
{
    /**
     * @return Chat[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Chat
     * @throws ChatNotFoundException
     */
    public function findChatOfId(int $id): Chat;

    /**
     * @param int $userId
     * @return Chat[]
     * @throws ChatNotFoundException
     */
    public function findByUserId(int $userId): array;

    /**
     * @param int $to
     * @param int $from
     * @return Chat[]
     * @throws ChatNotFoundException
     */
    public function getByUsers(int $to, int $from): array;

    /**
     * @param User $to
     * @param User $from
     * @return Chat
     * @throws ChatNotFoundException
     */
    public function createChat(User $to, User $from): Chat;

    /**
     * @param int $id
     * @return Void
     * @throws ChatNotFoundException
     */
    public function deleteChat(int $id): Void;
}
