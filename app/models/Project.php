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
        'start_date',
        'end_date',
        'description'
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
        $query = "SELECT * FROM project WHERE status = 'Ongoing' AND supervisor_id = :supervisor_id";
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
        $query = "SELECT * FROM project WHERE status = 'Completed' AND supervisor_id = :supervisor_id";
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
        $query = "SELECT p.*, 
                 COALESCE(p.start_date, 'Not Started') as start_date
                 FROM project p
                 WHERE p.supervisor_id = :supervisor_id
                 ORDER BY p.status, p.start_date DESC";
        
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
        // Simplified query to avoid join issues
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
            $project->events = $EventModel->getEventsByProject($projectId);
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
            $projects[$key]->events = $EventModel->getEventsByProject($project->id);
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
    
    /**
     * Update project progress
     * @param string $projectId Project ID
     * @param int $progress Progress percentage (0-100)
     * @return bool True if update successful
     */
    public function updateProjectProgress($projectId, $progress)
    {
        // Ensure progress is between 0 and 100
        $progress = max(0, min(100, $progress));
        
        // Update status to Completed if progress is 100%
        $status = ($progress == 100) ? 'Completed' : 'Ongoing';
        
        return $this->update($projectId, [
            'progress' => $progress,
            'status' => $status
        ]);
    }
    
    /**
     * Get projects by land ID
     * @param int $landId Land ID
     * @return array Array of projects
     */
    public function getProjectsByLandId($landId)
    {
        $query = "SELECT * FROM project WHERE land_id = :land_id";
        $data = [':land_id' => $landId];
        return $this->query($query, $data);
    }
    
    /**
     * Get projects by crop type
     * @param string $cropType Crop type
     * @return array Array of projects
     */
    public function getProjectsByCropType($cropType)
    {
        $query = "SELECT * FROM project WHERE crop_type = :crop_type";
        $data = [':crop_type' => $cropType];
        return $this->query($query, $data);
    }
    
    /**
     * Get projects by status
     * @param string $status Project status
     * @return array Array of projects
     */
    public function getProjectsByStatus($status)
    {
        $query = "SELECT * FROM project WHERE status = :status";
        $data = [':status' => $status];
        return $this->query($query, $data);
    }
    
    /**
     * Calculate project duration in days
     * @param string $projectId Project ID
     * @return int Duration in days
     */
    public function calculateProjectDuration($projectId)
    {
        $project = $this->getProjectById($projectId);
        
        if (!$project || !$project->start_date || !$project->end_date) {
            return 0;
        }
        
        $start = new DateTime($project->start_date);
        $end = new DateTime($project->end_date);
        $interval = $start->diff($end);
        
        return $interval->days;
    }
    
    /**
     * Get recent projects
     * @param int $limit Number of projects to return
     * @return array Array of recent projects
     */
    public function getRecentProjects($limit = 5)
    {
        $query = "SELECT p.*, u.name as supervisor_name 
                 FROM project p
                 JOIN user u ON p.supervisor_id = u.id
                 ORDER BY p.start_date DESC
                 LIMIT :limit";
        
        $data = [':limit' => $limit];
        return $this->query($query, $data);
    }
    
    /**
     * Search projects by keyword
     * @param string $keyword Search keyword
     * @return array Array of matching projects
     */
    public function searchProjects($keyword)
    {
        $keyword = "%$keyword%";
        
        $query = "SELECT p.*, u.name as supervisor_name, l.location as land_location
                 FROM project p
                 LEFT JOIN user u ON p.supervisor_id = u.id
                 LEFT JOIN land l ON p.land_id = l.id
                 WHERE p.id LIKE :keyword
                 OR p.crop_type LIKE :keyword
                 OR p.status LIKE :keyword
                 OR p.description LIKE :keyword
                 OR u.name LIKE :keyword
                 OR l.location LIKE :keyword";
        
        $data = [':keyword' => $keyword];
        return $this->query($query, $data);
    }
    
    /**
     * Get project statistics
     * @return object Statistics object
     */
    public function getProjectStatistics()
    {
        $stats = new stdClass();
        
        // Total projects
        $query = "SELECT COUNT(*) as count FROM project";
        $result = $this->query($query);
        $stats->total = $result[0]->count ?? 0;
        
        // Projects by status
        $query = "SELECT status, COUNT(*) as count FROM project GROUP BY status";
        $result = $this->query($query);
        $stats->by_status = [];
        
        foreach ($result as $row) {
            $stats->by_status[$row->status] = $row->count;
        }
        
        // Projects by crop type
        $query = "SELECT crop_type, COUNT(*) as count FROM project GROUP BY crop_type";
        $result = $this->query($query);
        $stats->by_crop = [];
        
        foreach ($result as $row) {
            $stats->by_crop[$row->crop_type] = $row->count;
        }
        
        return $stats;
    }
}
