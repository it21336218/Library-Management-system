<?php

// Interface for user repository operations
interface UserRepositoryInterface
{
    public function addUser(array $user): void;
    public function deleteUser(int $id): void;
    public function updateUser(array $user): void;
    public function listUsers(): void;
}

?>
