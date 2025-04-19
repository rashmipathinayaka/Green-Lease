<?php

class Project
{
    use Model;

    protected $table = 'project';

    protected $allowedColumns = [
        'id',
        'land_id',
        'duration',
        'crop_type'
    ];

    /**
     * Get projects by land ID(s)
     * @param int|array $landIds Single land ID or array of land IDs
     * @return array Array of project objects
     */
    public function getByLand($landIds)
    {
        if (is_array($landIds)) {
            if (empty($landIds)) {
                return [];
            }
            $placeholders = implode(',', array_fill(0, count($landIds), '?'));
            $query = "SELECT * FROM {$this->table} WHERE land_id IN ($placeholders)";
            return $this->query($query, $landIds);
        } else {
            return $this->where(['land_id' => $landIds]);
        }
    }

    /**
     * Get project with land details
     * @param int $projectId Project ID
     * @return object|null Project data with land information
     */
    public function getWithLand($projectId)
    {
        $query = "SELECT p.*, l.name as land_name 
                 FROM {$this->table} p
                 JOIN land l ON p.land_id = l.id
                 WHERE p.id = :id";

        $result = $this->query($query, ['id' => $projectId]);
        return $result[0] ?? null;
    }

    /**
     * Get all active projects
     * @return array Array of active projects
     */
    public function getActiveProjects()
    {
        return $this->where(['status' => 1]); // Assuming 1 means active
    }

    /**
     * Get projects by crop type
     * @param string $cropType Type of crop
     * @return array Array of matching projects
     */
    public function getByCropType($cropType)
    {
        return $this->where(['crop_type' => $cropType]);
    }
}
