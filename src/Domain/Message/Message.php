<?php

declare(strict_types=1);

namespace App\Domain\Message;

use App\Domain\Chat\Chat;
use App\Domain\User\User;
use App\Infrastructure\Persistence\Message\MessageSQLiteRepository;
use DateTime;
use JsonSerializable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Event\PrePersistEventArgs;



#[Entity(repositoryClass: MessageSQLiteRepository::class, readOnly: false), Table(name: 'messages')]
class Message implements JsonSerializable
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private ?int $id;

    #[Column(type: 'string', nullable: false)]
    private string $text;

    #[ManyToOne(targetEntity: User::class)]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $user;

    #[ManyToOne(targetEntity: Chat::class)]
    #[JoinColumn(name: 'chat_id', referencedColumnName: 'id', onDelete: 'cascade')]
    private Chat $chat;

    #[Column(type: 'datetime', nullable: false)]
    private \DateTime $createdAt;

    public function __construct(string $text, User $user, Chat $chat)
    {
        $this->text = $text;
        $this->user = $user;
        $this->chat = $chat;
        $this->createdAt = new DateTime();
    }

    #[PrePersist]
    public function doStuffOnPrePersist(PrePersistEventArgs $eventArgs)
    {
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChat(): Chat
    {
        return $this->chat;
    }

    public function setCchat(Chat $chat): void
    {
        $this->chat = $chat;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }
    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }


    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'user' => $this->user->jsonSerialize(),
            'chat' => $this->chat->jsonSerialize(),
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
        ];
    }
}
