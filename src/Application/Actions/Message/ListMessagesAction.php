<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use Psr\Http\Message\ResponseInterface as Response;

class ListMessagesAction extends MessageAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $messages = $this->em->getRepository('App\Domain\Message\Message')->findAll();


        return $this->respondWithData($messages);
    }
}
