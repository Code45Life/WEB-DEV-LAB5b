<?php


class User
{
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create a new user
    public function createUser($matric, $name, $password, $role)
    {
        try {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);

            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }

            $stmt->bind_param("ssss", $matric, $name, $password, $role);
            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Execute failed: " . $stmt->error);
            }
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

    // Read all users
    public function getUsers()
    {
        $sql = "SELECT matric, name, role FROM users";
        $result = $this->conn->query($sql);

        if (!$result) {
            throw new Exception("Query failed: " . $this->conn->error);
        }

        return $result;
    }

    // Read a single user by matric
    public function getUser($matric)
    {
        $sql = "SELECT * FROM users WHERE matric = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("s", $matric);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stmt->close();
        return $user;
    }

    // Update a user's information
    public function updateUser($matric, $name, $role)
    {
        try {
            $sql = "UPDATE users SET name = ?, role = ? WHERE matric = ?";
            $stmt = $this->conn->prepare($sql);

            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }

            $stmt->bind_param("sss", $name, $role, $matric);
            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Execute failed: " . $stmt->error);
            }
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

    // Delete a user by matric
    public function deleteUser($matric)
    {
        try {
            $sql = "DELETE FROM users WHERE matric = ?";
            $stmt = $this->conn->prepare($sql);

            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }

            $stmt->bind_param("s", $matric);
            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Execute failed: " . $stmt->error);
            }
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }
}
