<?php
class Report{

    use Controller;

    private $lands;
    private $bids;
    private $supervisor;

    public function __construct() {
        $this->lands = new RLand();
        $this->bids = new RBid();
        $this->supervisor = new RSupervisor();
    }

    public function index()
    {
        // This method can be used to display the report page or redirect to it
        // For now, we'll just call the generateReport method directly
        $this->generateReport();
    }

    public function generateReport()
    {
        // Fetching data for the report
        $landCount = $this->lands->countLands();
        $bidCount = $this->bids->countbids();
        $supervisorCount = $this->supervisor->countsupervisors();

        // Fetching land statistics for the report
        $landStats = $this->lands->findRegisteredYear();

        // Prepare data for the view
        $data = [
            'landCount' => $landCount,
            'bidCount' => $bidCount,
            'supervisorCount' => $supervisorCount,
            'yearLabels' => $landStats['labels'],
            'yearData' => $landStats['data'],
        ];

        // Load the report view with the data
        $this->view('admin/report', $data);
    }
}
