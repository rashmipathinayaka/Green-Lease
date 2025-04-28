<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Auth.php';

class Statistics {
    use Controller;
    private $financialModel;

    public function __construct() {
        // $auth = Auth::getInstance();
        // if (!$auth->isLoggedIn() || !$auth->hasRole(1)) { // 1 is admin role
        //     redirect('unauthorized');
        // }
        $this->financialModel = $this->model('SFinancial');
    }

    public function index() {
        $data = [
            'quality_metrics' => $this->financialModel->getQualityMetrics(),
            'zone_performance' => $this->financialModel->getZonePerformance(),
            'crop_performance' => $this->financialModel->getCropPerformance(),
            'project_timeline' => $this->financialModel->getProjectTimelineStats(),
            'supervisor_performance' => $this->financialModel->getSupervisorPerformance(),
            'sitehead_performance' => $this->financialModel->getSiteheadPerformance()
        ];

        $this->view('admin/statistics', $data);
    }
} 