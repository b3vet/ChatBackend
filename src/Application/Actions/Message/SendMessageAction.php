<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use App\Domain\DomainException\MissingParamsException;
use Psr\Http\Message\ResponseInterface as Response;

class SendMessageAction extends MessageAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $body = (array) $this->getFormData();

        if (!isset($body['to']) || !isset($body['from']) || !isset($body['text'])) {
            throw new MissingParamsException();
        }

        $to = $body['to'];
        $from = $body['from'];
        $text = $body['text'];

        $chats = $this->em->getRepository('App\Domain\Chat\Chat')->getByUsers($to, $from);

        $user1 = $this->em->getRepository('App\Domain\User\User')->findUserOfId($to);
        $user2 = $this->em->getRepository('App\Domain\User\User')->findUserOfId($from);

        if (count($chats) == 0) {
            /** @var Chat $chat */ 
            $chat = $this->em->getRepository('App\Domain\Chat\Chat')->createChat($user1, $user2);
        } else {
            /** @var Chat $chat */ 
            $chat = $chats[0];
        }

        $message = $this->em->getRepository('App\Domain\Message\Message')->createMessage($chat, $user2, $text);

        return $this->respondWithData($message);
    }
}
