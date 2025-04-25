<?php
class Project {
    use Model;
    
    protected $table = 'project';
    protected $allowedColumns = [
        'id',
        'land_id',
        'supervisor_id',
        'status',
        'duration',
        'crop_type',
        'address'
    ];
    
    /**
     * Count ongoing projects by supervisor ID
     * @param int $supervisorId Supervisor ID
     * @return int The count of ongoing projects
     */
    public function countOngoingProjectsBySupervisorId($supervisorId)
    {
        $result = $this->query("SELECT COUNT(*) AS count FROM project WHERE supervisor_id = :supervisor_id AND status = 'Ongoing'", ['supervisor_id' => $supervisorId]);
        return $result[0]->count ?? 0;
    }
    
    /**
     * Count completed projects by supervisor ID
     * @param int $supervisorId Supervisor ID
     * @return int The count of completed projects
     */
    public function countCompletedProjectsBySupervisorId($supervisorId)
    {
        $result = $this->query("SELECT COUNT(*) AS count FROM project WHERE supervisor_id = :supervisor_id AND status = 'Completed'", ['supervisor_id' => $supervisorId]);
        return $result[0]->count ?? 0;
    }
    
    /**
     * Get ongoing projects by supervisor ID
     * @param int $supervisorId Supervisor ID
     * @return array Array of ongoing projects
     */
    public function findOngoingProjects($supervisorId)
    {
        $query = "SELECT * FROM project WHERE status = 'Ongoing' AND supervisor_id = :supervisor_id";  // Status 'ongoing'
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
        $query = "SELECT * FROM project WHERE status = 'Completed' AND supervisor_id = :supervisor_id";  // Status 'completed'
        $data = [':supervisor_id' => $supervisorId];
        return $this->query($query, $data);
    }
    
    /**
     * Get all projects for a supervisor
     * @param int $supervisorId Supervisor ID
     * @return array Array of projects
     */
    public function getProjectsBySupervisor($supervisorId)
    {
        $query = "SELECT * FROM project WHERE supervisor_id = :supervisor_id";
        $data = [':supervisor_id' => $supervisorId];
        return $this->query($query, $data);
    }
    
    /**
     * Get project by ID
     * @param string $projectId Project ID
     * @return object|false Project object or false if not found
     */
    public function getProjectById($projectId)
    {
        $query = "SELECT * FROM project WHERE id = :id LIMIT 1";
        $data = [':id' => $projectId];
        $result = $this->query($query, $data);
        return !empty($result) ? $result[0] : false;
    }
    
    /**
     * Get project with events
     * @param string $projectId Project ID
     * @return object Project object with events array
     */
    public function getProjectWithEvents($projectId)
    {
        $project = $this->getProjectById($projectId);
        
        if ($project) {
            $EventModel = new EventModel();
            $project->EventModel = $EventModel->getEventsByProject($projectId);
        }
        
        return $project;
    }
    
    /**
     * Get all projects with events for a supervisor
     * @param int $supervisorId Supervisor ID
     * @return array Array of projects with events
     */
    public function getProjectsWithEvents($supervisorId)
    {
        $projects = $this->getProjectsBySupervisor($supervisorId);
        $EventModel = new EventModel();
        
        foreach ($projects as $key => $project) {
            $projects[$key]->event = $EventModel->getEventsByProject($project->id);
        }
        
        return $projects;
    }
    
    /**
     * Verify project belongs to supervisor
     * @param string $projectId Project ID
     * @param int $supervisorId Supervisor ID
     * @return bool True if project belongs to supervisor
     */
    public function verifyProjectBelongsToSupervisor($projectId, $supervisorId)
    {
        $query = "SELECT COUNT(*) AS count FROM project WHERE id = :id AND supervisor_id = :supervisor_id";
        $data = [':id' => $projectId, ':supervisor_id' => $supervisorId];
        $result = $this->query($query, $data);
        return ($result[0]->count > 0);
    }
}