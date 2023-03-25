<?php

declare(strict_types=1);

use App\Application\Actions\Chat\ChatsOfUserAction;
use App\Application\Actions\Message\ChatMessagesAction;
use App\Application\Actions\Chat\DeleteChatAction;
use App\Application\Actions\Chat\ListChatsAction;
use App\Application\Actions\Message\ListMessagesAction;
use App\Application\Actions\Message\MessagesToUserAction;
use App\Application\Actions\Message\SendMessageAction;
use App\Application\Actions\Message\DeleteMessageAction;
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Actions\User\CreateUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('WELCOME TO YOUR CHAT APP');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
        $group->post('', CreateUserAction::class);
    });

    $app->group('/messages', function (Group $group) {
        $group->get('', ListMessagesAction::class);
        $group->get('/{chatId}', ChatMessagesAction::class);
        $group->post('', SendMessageAction::class);
        $group->get('/to-user/{id}', MessagesToUserAction::class);
        $group->delete('/{id}', DeleteMessageAction::class);
    });

    $app->group('/chats', function (Group $group) {
        $group->get('', ListChatsAction::class);
        $group->get('/user/{id}', ChatsOfUserAction::class);
        $group->delete('/{id}', DeleteChatAction::class);
    });
};
