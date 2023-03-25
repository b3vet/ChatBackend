<?php

declare(strict_types=1);

namespace App\Domain\User;

interface UserRepository
{
    /**
     * @return User[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function findUserOfId(int $id): User;

    /**
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     * @return User
     * @throws UserNotFoundException
     */

    public function createUser(string $username, string $firstName, string $lastName): User;
}
