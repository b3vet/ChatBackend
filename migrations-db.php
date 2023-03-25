<?php
use Doctrine\DBAL\DriverManager;

return DriverManager::getConnection([
    'dbname' => 'chatDb',
    'user' => 'root',
    'password' => 'root',
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/chat_db.sqlite',
]);
