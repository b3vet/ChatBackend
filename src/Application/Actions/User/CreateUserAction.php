<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CreateUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $body = $this->getFormData();
        $user = $this->em->getRepository('App\Domain\User\User')->createUser($body['username'], $body['firstName'], $body['lastName']);

        return $this->respondWithData($user);
    }
}
