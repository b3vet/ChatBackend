<?php

declare(strict_types=1);

namespace App\Application\Actions\Chat;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Chat\Chat;
use App\Domain\Message\Message;

class ChatsOfUserAction extends ChatAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $chats = $this->em->getRepository('App\Domain\Chat\Chat')->findByUserId($userId);

        $chatIds = array_map(fn(Chat $value): int => $value->getId(), $chats);

        $messagesOfChats = $this->em->getRepository('App\Domain\Message\Message')->findByChatIds($chatIds);

        $responseObject = array_map(
            fn(Chat $chat): array =>
                [
                    ...($chat->jsonSerialize()),
                    'messages' => array_map(
                                function (Message $msg) {
                                    $message = $msg->jsonSerialize();
                                    unset($message['chat']);
                                    return $message;
                                }, 
                                array_filter($messagesOfChats, fn($message) => $message->getChat()->getId() == $chat->getId())
                            )
                ]
            , $chats);
        

        return $this->respondWithData($responseObject);
    }
}
