<?php

declare(strict_types=1);

namespace App\Domain\Chat;

use App\Domain\User\User;
use App\Infrastructure\Persistence\Chat\ChatSQLiteRepository;
use JsonSerializable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;



#[Entity(repositoryClass: ChatSQLiteRepository::class, readOnly: false), Table(name: 'chats')]
class Chat implements JsonSerializable
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private ?int $id;

    #[ManyToOne(targetEntity: User::class)]
    #[JoinColumn(name: 'user_1_id', referencedColumnName: 'id')]
    private User $user1;

    #[ManyToOne(targetEntity: User::class)]
    #[JoinColumn(name: 'user_2_id', referencedColumnName: 'id')]
    private User $user2;

    private array $messages;

    public function __construct(User $user1, User $user2)
    {
        $this->user1 = $user1;
        $this->user2 = $user2;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser1(): User
    {
        return $this->user1;
    }

    public function getUser2(): User
    {
        return $this->user2;
    }

    public function setUser1(User $user1): void
    {
        $this->user1 = $user1;
    }

    public function setUser2(User $user2): void
    {
        $this->user2 = $user2;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }

    public function setMessages(array $messages): void
    {
        $this->messages = $messages;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'user1' => $this->user1->jsonSerialize(),
            'user2' => $this->user2->jsonSerialize(),
        ];
    }
}
