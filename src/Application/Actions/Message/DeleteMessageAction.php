<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use Psr\Http\Message\ResponseInterface as Response;

class DeleteMessageAction extends MessageAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $messageId = (int) $this->resolveArg('id');
        $messages = $this->em->getRepository('App\Domain\Message\Message')->deleteMessage($messageId);

        return $this->respondWithData($messages);
    }
}
