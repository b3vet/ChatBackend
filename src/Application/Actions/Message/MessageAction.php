<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use App\Application\Actions\Action;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;

abstract class MessageAction extends Action
{
    protected EntityManager $em;

    public function __construct(LoggerInterface $logger, EntityManager $em)
    {
        parent::__construct($logger);
        $this->em = $em;
    }
}
