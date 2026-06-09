<?php

require_once __DIR__ . "/../config/koneksi.php";

class UserModel
{

    private $db;
    private $table = "users";

    public $id_user;
    public $username;
    public $email;
    public $password;
    public $role;

    public function __construct($koneksi)
    {
        $this->db = $koneksi;
    }

    public function login()
    {
        $query = "SELECT id_user, username, email, role, password, is_first_login FROM " . $this->table . " WHERE BINARY username=? OR BINARY email=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $this->username, $this->username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if ($row['username'] !== $this->username && $row['email'] !== $this->username) {
                return false;
            }

            $providedPassword = $this->password;
            $storedPassword = $row['password'];
            $pwInfo = password_get_info($storedPassword);
            $isHashed = !empty($pwInfo['algo']);

            if (password_verify($providedPassword, $storedPassword)) {
                $this->id_user = $row['id_user'];
                $this->username = $row['username'];
                $this->role = $row['role'];
                $this->is_first_login = $row['is_first_login'];
                return true;
            }
        }
        return false;
    }

    private function rehashPassword($id_user, $password)
    {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE " . $this->table . " SET password = ? WHERE id_user = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("si", $hashed, $id_user);
        $stmt->execute();
    }

    public function getUserCount()
    {
        $query = "SELECT COUNT(*) AS total FROM " . $this->table;
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        return (int)($row['total'] ?? 0);
    }

    public function updateLastActivity($id_user)
    {
        $query = "UPDATE users SET last_activity = NOW() WHERE id_user = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
    }

    public function getAllUsers()
    {
        $query = "SELECT * FROM " . $this->table . " ORDER BY last_activity DESC";
        return $this->db->query($query);
    }

    public function getUserById($id)
    {
        $query = "SELECT * FROM users WHERE id_user = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function createUser($username, $email, $password, $role)
    {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, email, password, role, is_first_login) VALUES (?, ?, ?, ?, 1)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssss", $username, $email, $hashed, $role);
        return $stmt->execute();
    }

    public function updateUser($id, $username, $email, $role, $password = null)
    {
        if ($password) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE users SET username=?, email=?, role=?, password=? WHERE id_user=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ssssi", $username, $email, $role, $hashed, $id);
        } else {
            $query = "UPDATE users SET username=?, email=?, role=? WHERE id_user=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("sssi", $username, $email, $role, $id);
        }
        return $stmt->execute();
    }

    public function deleteUser($id)
    {
        $query = "DELETE FROM users WHERE id_user = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function updatePassword($identifier, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $query = "UPDATE " . $this->table . " SET password = ? WHERE username = ? OR email = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sss", $hashedPassword, $identifier, $identifier);

        if ($stmt->execute()) {
            return $stmt->affected_rows > 0;
        }
        return false;
    }

    public function setOffline($id_user)
    {
        $query = "UPDATE users SET last_activity = NULL WHERE id_user = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_user);
        return $stmt->execute();
    }

    public function getUsersWithStats()
    {
        $sql = "SELECT u.id_user, u.username, u.email, u.role, u.last_activity,
            COUNT(n.id) as total_aktivitas,
            MAX(n.date) as aktivitas_terakhir
            FROM users u 
            LEFT JOIN notes n ON u.id_user = n.user_id 
            GROUP BY u.id_user";
        return mysqli_query($this->db, $sql);
    }

    public function getTotalSystemActivities()
    {
        $sql = "SELECT COUNT(*) as total FROM notes";
        $result = mysqli_query($this->db, $sql);
        return $result->fetch_assoc()['total'];
    }

    public function getUserActivityDetail($id_user)
    {
        $sql = "SELECT n.*, a.nama_area 
            FROM notes n 
            JOIN tb_area a ON n.id_area = a.id_area 
            WHERE n.user_id = ? 
            ORDER BY n.date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getAllSystemActivities()
    {

        $sql = "SELECT n.*, u.username, a.nama_area 
            FROM notes n 
            JOIN users u ON n.user_id = u.id_user 
            JOIN tb_area a ON n.id_area = a.id_area 
            ORDER BY n.date DESC";
        return $this->db->query($sql);
    }

    public function updatePasswordAndStatus($id_user, $newPassword)
    {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $query = "UPDATE users SET password = ?, is_first_login = 0 WHERE id_user = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("si", $hashed, $id_user);
        return $stmt->execute();
    }

    public function changeFirstPassword($id_user, $newPassword)
    {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $query = "UPDATE users SET password = ?, is_first_login = 0 WHERE id_user = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("si", $hashed, $id_user);
        return $stmt->execute();
    }

    public function updatePasswordAndStatusByIdentifier($identifier, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $query = "UPDATE " . $this->table . " SET password = ?, is_first_login = 0 WHERE username = ? OR email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sss", $hashedPassword, $identifier, $identifier);

        if ($stmt->execute()) {
            return $stmt->affected_rows > 0;
        }
        return false;
    }
}
