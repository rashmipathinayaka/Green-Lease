<?php
class Report{

    use Controller;

    private $lands;
    private $bids;
    private $supervisor;
    private $report;

    public function __construct() {
        $this->lands = new RLand();
        $this->bids = new RBid();
        $this->supervisor = new RSupervisor();
        $this->report = new RReprot();
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
        $buyerCount = $this->report->countbuyers();

        // Fetching land statistics for the report
        $landStats = $this->lands->findRegisteredYear();
$mostSelectedCrop = $this->report->mostseletectedcrop();
$mostprefferedCrop = $this->report->mostprefferedcrop();
$matchingcount=$this->report->getMatchingCropCount();
$totalprojects=$this->report->totalprojects();
$successrate=($matchingcount->match_count/$totalprojects)*100;
$mostlandzone=$this->report->mostlandzone();
$mostlandyear=$this->report->mostlandyear();








        $data = [
            'landCount' => $landCount,
            'bidCount' => $bidCount,
            'supervisorCount' => $supervisorCount,
            'buyerCount' => $buyerCount,
            'yearLabels' => $landStats['labels'],
            'yearData' => $landStats['data'],
            'mostselectedcrop' => $mostSelectedCrop,
            'mostprefferedCrop' => $mostprefferedCrop,
            'matchingcount'=>$matchingcount,
            'successrate'=>$successrate,
            'mostlandzone'=>$mostlandzone,
            'mostlandyear'=>$mostlandyear,
            



        ];

        // Load the report view with the data
        $this->view('admin/report', $data);
    }
}
