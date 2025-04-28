<?php
class Report
{

    use Controller;

    private $lands;
    private $bids;
    private $supervisor;
    private $report;

    public function __construct()
    {
        $this->lands = new RLand();
        $this->bids = new RBid();
        $this->supervisor = new RSupervisor();
        $this->report = new RReprot();
    }

    public function index()
    {
       
        $this->generateReport();
    }

    public function generateReport()
    {
        $landCount = $this->lands->countLands();
        $bidCount = $this->bids->countbids();
        $supervisorCount = $this->supervisor->countsupervisors();
        $buyerCount = $this->report->countbuyers();

        $landStats = $this->lands->findRegisteredYear();
        $mostSelectedCrop = $this->report->mostseletectedcrop();
        $mostprefferedCrop = $this->report->mostprefferedcrop();
        $matchingcount = $this->report->getMatchingCropCount();
        $totalprojects = $this->report->totalprojects();
        $successrate = round(($matchingcount->match_count / $totalprojects) * 100, 2);
        $mostlandzone = $this->report->mostlandzone();
        $mostlandyear = $this->report->mostlandyear();

        $noofpostponedevents = $this->report->countPostponedEventsThisYear();
        $totalevents = $this->report->gettotalevents();
        $eventpostponedrate=round(($noofpostponedevents/$totalevents)*100,2);






        $data = [
            'landCount' => $landCount,
            'bidCount' => $bidCount,
            'supervisorCount' => $supervisorCount,
            'buyerCount' => $buyerCount,
            'yearLabels' => $landStats['labels'],
            'yearData' => $landStats['data'],
            'mostselectedcrop' => $mostSelectedCrop,
            'mostprefferedCrop' => $mostprefferedCrop,
            'matchingcount' => $matchingcount,
            'successrate' => $successrate,
            'mostlandzone' => $mostlandzone,
            'mostlandyear' => $mostlandyear,
            'postponed' => $noofpostponedevents,
            'totalevents' => $totalevents,
'eventpostponedrate'=>$eventpostponedrate,

        ];

        $this->view('admin/report', $data);
    }
}
