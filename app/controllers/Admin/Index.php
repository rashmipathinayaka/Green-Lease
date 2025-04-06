<?php 

class Index
{
	use Controller;

	private $lands;
	private $bids;

	public function __construct() {
		$this->lands = new Land();
		$this->bids = new Bid();
	}

	public function index()
	{
		$userId = 19; // Example user ID

		$landCount = $userId ? $this->lands->countLands() : 0;
		$bidCount = $userId ? $this->bids->countbids() : 0;

		$data = [
			'landCount' => $landCount,
			'bidCount' => $bidCount,
			'total' => $this->lands->countLands(),
			'ongoing' => $this->lands->countOngoingProjects(),
			'unused' => $this->lands->countinactivelands(),
			'completed' => $this->lands->countcompletedProjects(),
		];


		$landStats = $this->lands->findRegisteredYear();
$data1['yearLabels'] = $landStats['labels'];
$data1['yearData'] = $landStats['data'];

$this->view('admin/Index', array_merge($data, $data1));


	}
}
