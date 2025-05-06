<?php

class Update_request
{
    use Controller;

    private $fertilizerRequestModel;
    private $fertilizerModel;
    private $siteheadModel;
    private $projectModel;

    public function __construct()
    {
        // Initialize all required models
        $this->fertilizerRequestModel = new FertilizerRequest();
        $this->fertilizerModel = new Fertilizer();
        $this->siteheadModel = new Sitehead();  // Make sure Sitehead model exists
        $this->projectModel = new Project();    // Make sure Project model exists
    }

    public function index() {}

    public function editRequest($requestId)
    {
        if (!isset($_SESSION['id'])) {
            redirect('login');
            return;
        }

        $request = $this->fertilizerRequestModel->first(['id' => $requestId]);

        if (!$request) {
            $this->view('_404');
            return;
        }

        $fertilizers = $this->fertilizerModel->findAll();
        $sitehead = $this->siteheadModel->first(['user_id' => $_SESSION['id']]);
        $projects = $this->projectModel->where(['land_id' => $sitehead->land_id]);

        $this->view('sitehead/edit_fertilizer_request', [
            'request' => $request,
            'fertilizers' => $fertilizers,
            'projects' => $projects
        ]);
    }

    public function updateRequest($requestId)
    {
        if (!isset($_SESSION['id'])) {
            redirect('login');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('_404');
            return;
        }

        $request = $this->fertilizerRequestModel->first(['id' => $requestId]);
        if (!$request) {
            $this->view('_404');
            return;
        }

        $updatedData = [
            'amount' => $_POST['amount'] ?? null,
            'fertilizer_id' => $_POST['fertilizer_id'] ?? null,
            'project_id' => $_POST['project_id'] ?? null,
            'preferred_date' => $_POST['preferred_date'] ?? null,
            'remarks' => $_POST['remarks'] ?? null,
        ];

        // update
        if ($this->fertilizerRequestModel->update($requestId, $updatedData)) {
            $_SESSION['success'] = 'Request updated successfully';
            redirect('Sitehead/Manage_fertilizer/requests');
            return;
        } else {
            $_SESSION['error'] = 'Failed to update request';
        }


        // If update fails, reload edit form with errors
        $fertilizers = $this->fertilizerModel->findAll();
        $sitehead = $this->siteheadModel->first(['user_id' => $_SESSION['id']]);
        $projects = $this->projectModel->where(['land_id' => $sitehead->land_id]);

        $this->view('sitehead/edit_fertilizer_request', [
            'request' => (object) array_merge((array) $request, $updatedData),
            'fertilizers' => $fertilizers,
            'projects' => $projects,
            'errors' => $this->fertilizerRequestModel->errors
        ]);
    }
}
