<?php

declare(strict_types=1);

use App\Domain\User\UserRepository;
use App\Domain\Chat\ChatRepository;
use App\Domain\Message\MessageRepository;
use App\Infrastructure\Persistence\Message\MessageSQLiteRepository;
use App\Infrastructure\Persistence\User\UserSQLiteRepository;
use App\Infrastructure\Persistence\Chat\ChatSQLiteRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        MessageRepository::class => \DI\autowire(MessageSQLiteRepository::class),
    ]);

    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(UserSQLiteRepository::class),
    ]);

    $containerBuilder->addDefinitions([
        ChatRepository::class => \DI\autowire(ChatSQLiteRepository::class),
    ]);
};
