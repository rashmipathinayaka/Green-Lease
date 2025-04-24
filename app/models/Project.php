<?php

class Project
{
    use Model;

    protected $table = 'project';

    protected $allowedColumns = [
        'id',
        'land_id',
        'supervisor_id',
        'status',
        'duration',
        'crop_type'
    ];

    /**
     * Count ongoing projects by supervisor ID
     * @param int $supervisorId Supervisor ID
     * @return int The count of ongoing projects
     */
    public function countOngoingProjectsBySupervisorId($supervisorId)
    {
        $result = $this->query("SELECT COUNT(*) AS count FROM {$this->table} WHERE supervisor_id = :supervisor_id AND status = 'ongoing'", ['supervisor_id' => $supervisorId]);
        return $result[0]->count ?? 0;
    }

    /**
     * Count completed projects by supervisor ID
     * @param int $supervisorId Supervisor ID
     * @return int The count of completed projects
     */
    public function countCompletedProjectsBySupervisorId($supervisorId)
    {
        $result = $this->query("SELECT COUNT(*) AS count FROM {$this->table} WHERE supervisor_id = :supervisor_id AND status = 'completed'", ['supervisor_id' => $supervisorId]);
        return $result[0]->count ?? 0;
    }

    /**
     * Get ongoing projects by supervisor ID
     * @param int $supervisorId Supervisor ID
     * @return array Array of ongoing projects
     */
    public function findOngoingProjects($supervisorId)
    {
        $query = "SELECT * FROM {$this->table} WHERE status = 'ongoing' AND supervisor_id = :supervisor_id";  // Status 'ongoing'
        $data = [':supervisor_id' => $supervisorId];
        return $this->query($query, $data);
    }

    /**
     * Get completed projects by supervisor ID
     * @param int $supervisorId Supervisor ID
     * @return array Array of completed projects
     */
    public function findCompletedProjects($supervisorId)
    {
        $query = "SELECT * FROM {$this->table} WHERE status = 'completed' AND supervisor_id = :supervisor_id";  // Status 'completed'
        $data = [':supervisor_id' => $supervisorId];
        return $this->query($query, $data);
    }
}
