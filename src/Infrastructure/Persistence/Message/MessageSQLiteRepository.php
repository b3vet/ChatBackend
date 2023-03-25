<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Message;

use App\Domain\Message\Message;
use App\Domain\Message\MessageNotFoundException;
use App\Domain\Message\MessageRepository;
use Doctrine\ORM\EntityRepository;
use App\Domain\Chat\Chat;
use App\Domain\User\User;

class MessageSQLiteRepository extends EntityRepository implements MessageRepository
{
    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findMessagesOfChat(int $chatId): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.chat = :chatId')
            ->setParameter('chatId', $chatId)
            ->orderBy('m.id', 'DESC')
            ->getQuery()
            ->getResult();

    }

    /**
     * {@inheritdoc}
     */
    public function createMessage(Chat $chat, User $from, string $text): Message {
        $message = new Message($text, $from, $chat);
        $this->getEntityManager()->persist($message);
        $this->getEntityManager()->flush();

        return $message;
    }

    /**
     * {@inheritdoc}
     */
    public function findByChatIds(array $ids): array {
        return $this->createQueryBuilder('m')
            ->where('m.chat IN (:ids)')
            ->setParameter('ids', $ids)
            ->orderBy('m.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function deleteMessage(int $id): Void {
        $message = $this->find($id);

        if (!$message) {
            throw new MessageNotFoundException();
        }

        $this->getEntityManager()->remove($message);
        $this->getEntityManager()->flush();
    }
}
