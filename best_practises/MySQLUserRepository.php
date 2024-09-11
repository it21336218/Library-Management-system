<?php

// MySQL implementation of UserRepositoryInterface
class MySQLUserRepository implements UserRepositoryInterface
{
    private $connection;

    // Constructor to initialize database connection
    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    // Add a new user to the database
    public function addUser(array $user): void
    {
        $sql = "INSERT INTO users (name, email, role) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        if ($stmt === false) {
            die("Error preparing statement: " . $this->connection->error);
        }
        $stmt->bind_param("sss", $user['name'], $user['email'], $user['role']);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo "User added successfully.<br>";
        } else {
            echo "Failed to add user.<br>";
        }
        $stmt->close();
    }

    // Delete a user from the database by ID
    public function deleteUser(int $id): void
    {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        if ($stmt === false) {
            die("Error preparing statement: " . $this->connection->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo "User deleted successfully.<br>";
        } else {
            echo "Failed to delete user.<br>";
        }
        $stmt->close();
    }

    // Update an existing user in the database
    public function updateUser(array $user): void
    {
        $sql = "UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        if ($stmt === false) {
            die("Error preparing statement: " . $this->connection->error);
        }
        $stmt->bind_param("sssi", $user['name'], $user['email'], $user['role'], $user['id']);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo "User updated successfully.<br>";
        } else {
            echo "Failed to update user.<br>";
        }
        $stmt->close();
    }

    // List all users from the database
    public function listUsers(): void
    {
        $sql = "SELECT * FROM users";
        $result = $this->connection->query($sql);
        if ($result === false) {
            die("Error executing query: " . $this->connection->error);
        }
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "ID: " . $row["id"] . " - Name: " . $row["name"] . " - Email: " . $row["email"] . " - Role: " . $row["role"] . "<br>";
            }
        } else {
            echo "No users found.<br>";
        }
        $result->free();
    }
}

?>
