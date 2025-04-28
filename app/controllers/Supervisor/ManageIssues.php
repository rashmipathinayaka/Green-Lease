<?php

class ManageIssues
{
    use Controller;

    private $issueModel;
    private $userModel;
    private $siteheadModel;

    public function __construct()
    {
        $this->issueModel = new Issue();
        $this->userModel = new User();
        $this->siteheadModel = new Sitehead();
    }

    public function index()
    {

        $data = ['errors' => []]; // Initialize errors array

        // Check if user is logged in
        if (!isset($_SESSION['id'])) {
            $this->view('404');
            return;
        }

        $userId = $_SESSION['id'];

        // Get sitehead's data
        $supervisorModel = new supervisor();
        $supervisorData = $supervisorModel->first(['user_id' => $userId]);

        if (!empty($supervisorData)) {
            // Get project IDs of the superviosr
            $projectModel = new Project();
            $data['projects'] = []; // Initialize empty array

            $projects = $projectModel->where([
                'supervisor_id' => $supervisorData->id,
                'status' => 'ongoing'
            ]);

            foreach ($projects as $project) {
                $data['projects'][] = $project; // Store full project objects
            }

            // Fetch all pending issues with user details
            $pendingIssues = $this->getIssuesWithUserDetails('pending', $projects);

            // Fetch all solved issues with user details
            $solvedIssues = $this->getIssuesWithUserDetails('solved', $projects);

            $this->view('supervisor/issue', [
                'pendingIssues' => $pendingIssues,
                'solvedIssues' => $solvedIssues,
            ]);
        }
    }

    private function getIssuesWithUserDetails($status, $SupervisorProjects)
    {
        $validIssues = [];

        foreach ($SupervisorProjects as $project) {
            $issues = $this->issueModel->where([
                'status' => $status,
                'sitehead_id' => $project->sitehead_id
            ]);

            if (!empty($issues)) {
                foreach ($issues as $issue) {
                    // Get sitehead record
                    $sitehead = $this->siteheadModel->first(['id' => $issue->sitehead_id]);

                    if ($sitehead) {
                        // Get user details
                        $user = $this->userModel->first(['id' => $sitehead->user_id]);

                        if ($user) {
                            // Add user details to the issue object
                            $issue->user_name = $user->full_name;
                            $issue->contact_no = $user->contact_no;

                            $validIssues[] = $issue;
                        }
                    }
                }
            }
        }

        return $validIssues;
    }


    public function markAsSolved($id)
    {
        // Update the status of the issue to 'solved'

        if ($this->issueModel->update($id, ['status' => 'solved'], 'id')) {
            // Redirect back to the Manage Issues page
            // $this->view('/Supervisor/ManageIssues');
            header('Location: ' . URLROOT . '/Supervisor/ManageIssues');
        } else {
            // Show an error page if the update fails
            $this->view('_404');
        }
    }

    public function deleteIssue($id)
    {
        // Delete the issue with the specified ID
        if ($this->issueModel->delete($id)) {
            // Redirect back to the Manage Issues page
            header('Location: ' . URLROOT . '/Supervisor/ManageIssues');
        } else {
            // Show an error page if deletion fails
            $this->view('_404');
        }
    }
}
