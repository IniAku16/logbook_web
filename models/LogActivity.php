<?php
class LogActivity
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function save($user_id, $action, $module, $description, $old_data = null, $new_data = null)
    {

        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            return true;
        }

        $query = "INSERT INTO log_activity (user_id, action, module, description, data_old, data_new, ip_address, user_agent) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);

        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

        $old_data_json = $old_data ? json_encode($old_data) : null;
        $new_data_json = $new_data ? json_encode($new_data) : null;

        $stmt->bind_param(
            "isssssss",
            $user_id,
            $action,
            $module,
            $description,
            $old_data_json,
            $new_data_json,
            $ip,
            $user_agent
        );

        return $stmt->execute();
    }

    public function getAllLogs()
    {
        $query = "SELECT l.*, u.username FROM log_activity l 
                  LEFT JOIN users u ON l.user_id = u.id_user 
                  ORDER BY l.created_at DESC";
        return $this->db->query($query);
    }
}
