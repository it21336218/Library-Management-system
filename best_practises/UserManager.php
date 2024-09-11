<?php

// Manages user operations using a UserRepositoryInterface
class UserManager
{
    private $repository;

    // Constructor to initialize repository
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    // Add a new user
    public function addUser(array $user): void
    {
        $this->repository->addUser($user);
    }

    // Delete a user by ID
    public function deleteUser(int $id): void
    {
        $this->repository->deleteUser($id);
    }

    // Update an existing user
    public function updateUser(array $user): void
    {
        $this->repository->updateUser($user);
    }

    // List all users
    public function listUsers(): void
    {
        $this->repository->listUsers();
    }
}

?>
