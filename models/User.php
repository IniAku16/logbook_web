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
    public $is_first_login;

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
            if (password_verify($this->password, $row['password'])) {
                $this->id_user = $row['id_user'];
                $this->username = $row['username'];
                $this->role = $row['role'];
                $this->is_first_login = $row['is_first_login'];
                return true;
            }
        }
        return false;
    }

    public function getAllUsers()
    {
        $query = "SELECT * FROM " . $this->table . " ORDER BY last_activity DESC";
        return $this->db->query($query);
    }

    public function getUserById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id_user = ?";
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

    public function resetPasswordByAdmin($id, $newPassword)
    {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $query = "UPDATE users SET password = ?, is_first_login = 1 WHERE id_user = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("si", $hashed, $id);
        return $stmt->execute();
    }

    public function changePasswordByUser($identifier, $newPassword)
    {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $query = "UPDATE users SET password = ?, is_first_login = 0 WHERE username = ? OR email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sss", $hashed, $identifier, $identifier);
        return $stmt->execute();
    }

    public function getUsersWithStats()
    {

        $query = "SELECT u.*, 
                     COUNT(n.user_id) as total_aktivitas, 
                     MAX(n.date) as aktivitas_terakhir 
              FROM users u 
              LEFT JOIN notes n ON u.id_user = n.user_id 
              GROUP BY u.id_user 
              ORDER BY total_aktivitas DESC";
        return $this->db->query($query);
    }

    public function getUserActivityDetail($id_user)
    {
        $query = "SELECT n.*, a.nama_area 
                  FROM notes n 
                  JOIN tb_area a ON n.id_area = a.id_area 
                  WHERE n.user_id = ? 
                  ORDER BY n.date DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function updateLastActivity($id_user)
    {
        $query = "UPDATE users SET last_activity = NOW() WHERE id_user = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
    }

    public function setOffline($id_user)
    {
        $query = "UPDATE users SET last_activity = NULL WHERE id_user = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_user);
        return $stmt->execute();
    }

    public function getUserCount()
    {
        $query = "SELECT COUNT(*) AS total FROM " . $this->table;
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        return (int)($row['total'] ?? 0);
    }

    public function getTotalSystemActivities()
    {
        $sql = "SELECT COUNT(*) as total FROM notes";
        $result = $this->db->query($sql);
        return $result->fetch_assoc()['total'] ?? 0;
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

    public function kirimPermintaanReset($input)
    {
        $check = $this->db->prepare("SELECT id_user FROM users WHERE username = ? OR email = ?");
        $check->bind_param("ss", $input, $input);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $stmt = $this->db->prepare("INSERT INTO reset_password_requests (username_email) VALUES (?)");
            $stmt->bind_param("s", $input);
            return $stmt->execute();
        }
        return false;
    }

    public function getSemuaPermintaanReset()
    {
        return $this->db->query("SELECT * FROM reset_password_requests ORDER BY created_at DESC");
    }

    public function hapusNotifikasiReset($id)
    {
        $stmt = $this->db->prepare("DELETE FROM reset_password_requests WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
