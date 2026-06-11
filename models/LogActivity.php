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
        $query = "INSERT INTO log_activity (user_id, action, module, description, data_old, data_new, ip_address, user_agent) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);

        $ip = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        return $stmt->execute([
            $user_id,
            $action,
            $module,
            $description,
            json_encode($old_data),
            json_encode($new_data),
            $ip,
            $user_agent
        ]);
    }

    public function getAllLogs()
    {
        $query = "SELECT l.*, u.username FROM log_activity l 
                  JOIN users u ON l.user_id = u.id_user 
                  ORDER BY l.created_at DESC";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }
}
