<?php
class Report
{

    use Controller;

    private $lands;
    private $bids;
    private $supervisor;
    private $report;
    private $financial;

    public function __construct()
    {
        $this->lands = new RLand();
        $this->bids = new RBid();
        $this->supervisor = new RSupervisor();
        $this->report = new RReprot();
        $this->financial = new SFinancial();
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
        $eventpostponedrate = round(($noofpostponedevents / $totalevents) * 100, 2);

        // Fetching financial data for the report
        $totalIncome = $this->financial->getTotalIncome();
        $mostProfitableCrop = $this->financial->getMostProfitableCrop();
        $mostContributingSupervisor = $this->financial->getMostContributingSupervisor();
        $mostContributingSitehead = $this->financial->getMostContributingSitehead();
        $incomeByCropType = $this->financial->getIncomeByCropType();

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
            'eventpostponedrate' => $eventpostponedrate,
            // Adding financial data
            'totalIncome' => $totalIncome,
            'mostProfitableCrop' => $mostProfitableCrop,
            'mostContributingSupervisor' => $mostContributingSupervisor,
            'mostContributingSitehead' => $mostContributingSitehead,
            'incomeByCropType' => $incomeByCropType
        ];

        $this->view('admin/report', $data);
    }
}
