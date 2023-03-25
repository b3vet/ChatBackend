<?php

// cli-config.php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

/** @var EntityManager $entityManager */
$entityManager = require_once __DIR__ . '/bootstrap.php';

return ConsoleRunner::createHelperSet($entityManager);