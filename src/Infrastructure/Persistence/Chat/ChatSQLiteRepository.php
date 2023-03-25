<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Chat;

use App\Domain\Chat\Chat;
use App\Domain\Chat\ChatNotFoundException;
use App\Domain\Chat\ChatRepository;
use Doctrine\ORM\EntityRepository;
use App\Domain\User\User;

class ChatSQLiteRepository extends EntityRepository implements ChatRepository
{
    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findChatOfId(int $id): Chat
    {
        $chat = $this->find($id);

        if (!$chat) {
            throw new ChatNotFoundException();
        }

        return $chat;
    }

    /**
     * {@inheritdoc}
     */
    public function findByUserId(int $userId): array {
        return $this->createQueryBuilder('c')
            ->where('c.user1 = :userId')
            ->orWhere('c.user2 = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function getByUsers(int $to, int $from): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.user1 = :to AND c.user2 = :from')
            ->orWhere('c.user1 = :from AND c.user2 = :to')
            ->setParameter('to', $to)
            ->setParameter('from', $from)
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function createChat(User $to, User $from): Chat {
        $chat = new Chat($to, $from);
        $this->getEntityManager()->persist($chat);
        $this->getEntityManager()->flush();

        return $chat;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteChat(int $id): Void {
        $chat = $this->findChatOfId($id);
        $this->getEntityManager()->remove($chat);
        $this->getEntityManager()->flush();
    }
}
