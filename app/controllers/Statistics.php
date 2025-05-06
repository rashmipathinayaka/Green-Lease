<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Auth.php';

class Statistics {
    use Controller;
    private $financialModel;

    public function __construct() {
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