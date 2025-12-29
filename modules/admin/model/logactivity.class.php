<?php defined('BORDAMEX') || exit;

class LogActivity extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function logActivity($member_id, $action_type, $action_description)
    {
        $member_id = intval($member_id);
        $action_type = $this->db->real_escape_string($action_type);
        $action_description = $this->db->real_escape_string($action_description);

        $query = $this->db->query("INSERT INTO activity_log (member_id, action_type, action_description) VALUES ({$member_id}, '{$action_type}', '{$action_description}')");

        return $query;
    }

    public function getActivityLogs($member_id, $limit = 10)
    {
        $member_id = intval($member_id);

        $query = $this->db->query("SELECT * FROM activity_log WHERE member_id = {$member_id} ORDER BY timestamp DESC LIMIT {$limit}");

        if ($query && $query->num_rows > 0)
        {
            $logs = [];
            while ($row = $query->fetch_assoc())
            {
                $logs[] = $row;
            }
            return $logs;
        }

        return false;
    }
}
