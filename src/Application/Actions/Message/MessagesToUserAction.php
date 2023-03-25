<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Chat\Chat;
use App\Domain\Message\Message;

class MessagesToUserAction extends MessageAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');

        $chatsOfUser = $this->em->getRepository('App\Domain\Chat\Chat')->findByUserId($userId);

        $chatIds = array_map(fn(Chat $value): int => $value->getId(), $chatsOfUser);

        $messages = $this->em->getRepository('App\Domain\Message\Message')->findByChatIds($chatIds);

        $responseObject = array_map(function (Message $msg) {
            $message = $msg->jsonSerialize();
            unset($message['chat']);
            return $message;
        }
        ,array_filter(
            $messages,
            fn(Message $message): bool => $message->getUser()->getId() !== $userId,
        ));
        


        return $this->respondWithData($responseObject);
    }
}
