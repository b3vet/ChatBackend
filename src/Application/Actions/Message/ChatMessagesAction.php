<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use Psr\Http\Message\ResponseInterface as Response;

class ChatMessagesAction extends MessageAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $chatId = (int) $this->resolveArg('chatId');
        $messages = $this->em->getRepository('App\Domain\Message\Message')->findMessagesOfChat($chatId);

        return $this->respondWithData($messages);
    }
}
