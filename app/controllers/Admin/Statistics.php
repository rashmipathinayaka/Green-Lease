<?php 

class Statistics
{
    use Controller;

    private $sfinancial;

    public function __construct() {
        $this->sfinancial = new SFinancial();
    }

    public function index()
    {
        // Check if user is logged in and has admin role
        $auth = Auth::getInstance();
        if (!$auth->isLoggedIn() || !$auth->hasRole(1)) {
            redirect('unauthorized');
            return;
        }

        // Get all statistics data
        $data = [
            'quality_metrics' => $this->sfinancial->getQualityMetrics(),
            'zone_performance' => $this->sfinancial->getZonePerformance(),
            'crop_performance' => $this->sfinancial->getCropPerformance(),
            'project_timeline' => $this->sfinancial->getProjectTimelineStats(),
            'supervisor_performance' => $this->sfinancial->getSupervisorPerformance(),
            'sitehead_performance' => $this->sfinancial->getSiteheadPerformance()
        ];

        $this->view('admin/statistics', $data);
    }
} 