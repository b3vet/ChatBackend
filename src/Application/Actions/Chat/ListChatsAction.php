<?php

declare(strict_types=1);

namespace App\Application\Actions\Chat;

use Psr\Http\Message\ResponseInterface as Response;

class ListChatsAction extends ChatAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $chats = $this->em->getRepository('App\Domain\Chat\Chat')->findAll();


        return $this->respondWithData($chats);
    }
}
