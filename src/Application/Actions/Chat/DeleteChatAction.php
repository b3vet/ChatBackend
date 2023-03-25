<?php

declare(strict_types=1);

namespace App\Application\Actions\Chat;

use Psr\Http\Message\ResponseInterface as Response;

class DeleteChatAction extends ChatAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $chatId = (int) $this->resolveArg('id');
        $messages = $this->em->getRepository('App\Domain\Chat\Chat')->deleteChat($chatId);

        return $this->respondWithData($messages);
    }
}
