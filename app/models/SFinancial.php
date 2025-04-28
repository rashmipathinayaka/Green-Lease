<?php
class SFinancial
{
    use Model;

    protected $table = 'purchase';

    /**
     * Get total income from all completed projects
     * @return float Total income
     */
    public function getTotalIncome()
    {
        $query = "SELECT SUM(p.amount) as total_income 
                 FROM purchase p 
                 INNER JOIN bid b ON p.bid_id = b.id 
                 INNER JOIN harvest h ON b.harvest_id = h.id 
                 INNER JOIN project pr ON h.project_id = pr.id 
                 WHERE pr.status = 'Completed'";
        $result = $this->query($query);
        return $result[0]->total_income ?? 0;
    }

    /**
     * Get most profitable crop type
     * @return array Crop type and total income
     */
    public function getMostProfitableCrop()
    {
        $query = "SELECT pr.crop_type, SUM(p.amount) as total_income 
                 FROM purchase p 
                 INNER JOIN bid b ON p.bid_id = b.id 
                 INNER JOIN harvest h ON b.harvest_id = h.id 
                 INNER JOIN project pr ON h.project_id = pr.id 
                 WHERE pr.status = 'Completed'
                 GROUP BY pr.crop_type 
                 ORDER BY total_income DESC 
                 LIMIT 1";
        $result = $this->query($query);
        return $result[0] ?? null;
    }

    /**
     * Get most contributing supervisor
     * @return array Supervisor details and total contribution
     */
    public function getMostContributingSupervisor()
    {
        $query = "SELECT s.id, u.full_name as user_name, 
                        SUM(p.amount) as total_contribution
                 FROM purchase p 
                 INNER JOIN bid b ON p.bid_id = b.id 
                 INNER JOIN harvest h ON b.harvest_id = h.id 
                 INNER JOIN project pr ON h.project_id = pr.id 
                 INNER JOIN supervisor s ON pr.supervisor_id = s.id
                 INNER JOIN user u ON s.user_id = u.id
                 WHERE pr.status = 'Completed'
                 GROUP BY s.id, u.full_name
                 ORDER BY total_contribution DESC 
                 LIMIT 1";
        $result = $this->query($query);
        return $result[0] ?? null;
    }

    /**
     * Get most contributing sitehead
     * @return array Sitehead details and total contribution
     */
    public function getMostContributingSitehead()
    {
        $query = "SELECT sh.id, u.full_name as user_name, 
                        SUM(p.amount) as total_contribution
                 FROM purchase p 
                 INNER JOIN bid b ON p.bid_id = b.id 
                 INNER JOIN harvest h ON b.harvest_id = h.id 
                 INNER JOIN project pr ON h.project_id = pr.id 
                 INNER JOIN sitehead sh ON pr.sitehead_id = sh.id
                 INNER JOIN user u ON sh.user_id = u.id
                 WHERE pr.status = 'Completed'
                 GROUP BY sh.id, u.full_name
                 ORDER BY total_contribution DESC 
                 LIMIT 1";
        $result = $this->query($query);
        return $result[0] ?? null;
    }

    /**
     * Get income by crop type
     * @return array List of crop types and their total income
     */
    public function getIncomeByCropType()
    {
        $query = "SELECT pr.crop_type, SUM(p.amount) as total_income 
                 FROM purchase p 
                 INNER JOIN bid b ON p.bid_id = b.id 
                 INNER JOIN harvest h ON b.harvest_id = h.id 
                 INNER JOIN project pr ON h.project_id = pr.id 
                 WHERE pr.status = 'Completed'
                 GROUP BY pr.crop_type 
                 ORDER BY total_income DESC";
        return $this->query($query);
    }

    public function getQualityMetrics() {
        $sql = "SELECT 
                    AVG(pu.rating) as overall_rating,
                    COUNT(DISTINCT CASE WHEN pu.rating >= 4 THEN p.id END) as high_quality_projects,
                    COUNT(DISTINCT p.id) as total_projects,
                    (COUNT(DISTINCT CASE WHEN pu.rating >= 4 THEN p.id END) / COUNT(DISTINCT p.id)) * 100 as quality_percentage
                FROM project p
                JOIN harvest h ON p.id = h.project_id
                JOIN bid b ON h.id = b.harvest_id
                JOIN purchase pu ON b.id = pu.bid_id
                WHERE p.status = 'Completed'";
        
        return $this->query($sql)[0] ?? null;
    }

    public function getZonePerformance() {
        $sql = "SELECT 
                    l.zone,
                    COUNT(DISTINCT p.id) as total_projects,
                    SUM(pu.amount) as total_income,
                    AVG(pu.rating) as average_rating
                FROM project p
                JOIN land l ON p.land_id = l.id
                JOIN harvest h ON p.id = h.project_id
                JOIN bid b ON h.id = b.harvest_id
                JOIN purchase pu ON b.id = pu.bid_id
                WHERE p.status = 'Completed'
                GROUP BY l.zone
                ORDER BY total_income DESC";
        
        return $this->query($sql);
    }

    public function getCropPerformance() {
        $sql = "SELECT 
                    p.crop_type,
                    COUNT(DISTINCT p.id) as total_projects,
                    SUM(pu.amount) as total_income,
                    AVG(pu.rating) as average_rating,
                    AVG(h.max_amount) as average_yield
                FROM project p
                JOIN harvest h ON p.id = h.project_id
                JOIN bid b ON h.id = b.harvest_id
                JOIN purchase pu ON b.id = pu.bid_id
                WHERE p.status = 'Completed'
                GROUP BY p.crop_type
                ORDER BY total_income DESC";
        
        return $this->query($sql);
    }

    public function getProjectTimelineStats() {
        $sql = "SELECT 
                    MONTH(p.start_date) as month,
                    COUNT(DISTINCT p.id) as projects_started,
                    COUNT(DISTINCT CASE WHEN p.status = 'Completed' THEN p.id END) as projects_completed,
                    SUM(CASE WHEN p.status = 'Completed' THEN pu.amount ELSE 0 END) as monthly_income
                FROM project p
                LEFT JOIN harvest h ON p.id = h.project_id
                LEFT JOIN bid b ON h.id = b.harvest_id
                LEFT JOIN purchase pu ON b.id = pu.bid_id
                WHERE YEAR(p.start_date) = YEAR(CURRENT_DATE)
                GROUP BY MONTH(p.start_date)
                ORDER BY month";
        
        return $this->query($sql);
    }

    public function getSupervisorPerformance() {
        $sql = "SELECT 
                    u.full_name as supervisor_name,
                    COUNT(DISTINCT p.id) as total_projects,
                    SUM(pu.amount) as total_income,
                    AVG(pu.rating) as average_rating,
                    AVG(DATEDIFF(p.end_date, p.start_date)) as avg_project_duration
                FROM project p
                JOIN supervisor s ON p.supervisor_id = s.id
                JOIN user u ON s.user_id = u.id
                JOIN harvest h ON p.id = h.project_id
                JOIN bid b ON h.id = b.harvest_id
                JOIN purchase pu ON b.id = pu.bid_id
                WHERE p.status = 'Completed'
                GROUP BY u.id, u.full_name
                ORDER BY total_income DESC";
        
        return $this->query($sql);
    }

    public function getSiteheadPerformance() {
        $sql = "SELECT 
                    u.full_name as sitehead_name,
                    COUNT(DISTINCT p.id) as total_projects,
                    SUM(pu.amount) as total_income,
                    AVG(pu.rating) as average_rating,
                    AVG(DATEDIFF(p.end_date, p.start_date)) as avg_project_duration
                FROM project p
                JOIN sitehead sh ON p.sitehead_id = sh.id
                JOIN user u ON sh.user_id = u.id
                JOIN harvest h ON p.id = h.project_id
                JOIN bid b ON h.id = b.harvest_id
                JOIN purchase pu ON b.id = pu.bid_id
                WHERE p.status = 'Completed'
                GROUP BY u.id, u.full_name
                ORDER BY total_income DESC";
        
        return $this->query($sql);
    }
} 