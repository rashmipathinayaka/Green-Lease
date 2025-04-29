<?php 

class Index
{
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
		$userId = $_SESSION['id'];

		$landCount = $userId ? $this->lands->countLands() : 0;
		$bidCount = $userId ? $this->bids->countbids() : 0;

		$data = [
			'landCount' => $landCount,
			'bidCount' => $bidCount,
			'total' => $this->lands->countLands(),
			'ongoing' => $this->lands->countOngoingProjects(),
			'unused' => $this->lands->countinactivelands(),
			'completed' => $this->lands->countcompletedProjects(),
			'supervisorcount' => $this->supervisor->countsupervisors(),
			'buyercount'=>$this->lands->countbuyers(),
		];

		$landStats = $this->lands->findRegisteredYear();
		$data1['yearLabels'] = $landStats['labels'];
		$data1['yearData'] = $landStats['data'];

		$this->view('admin/Index', array_merge($data, $data1));
	}

	public function generateReport()
	{
		$landCount = $this->lands->countLands();
		$bidCount = $this->bids->countbids();
		$supervisorcount = $this->supervisor->countsupervisors();

		$landStats = $this->lands->findRegisteredYear();

		$data = [
			'landCount' => $landCount,
			'bidCount' => $bidCount,
			'supervisorcount' => $supervisorcount,
			'yearLabels' => $landStats['labels'],
			'yearData' => $landStats['data'],
			'buyercount'=>$buyercount,
		];

		$this->view('admin/report', $data);
	}
}
 