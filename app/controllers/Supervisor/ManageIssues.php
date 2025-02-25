<?php

class ManageIssues
{
    use Controller;

    // Declare a class property for the Issue model
    private $issueModel;

    public function __construct()
    {
        // Initialize the Issue model in the constructor
        $this->issueModel = new Issue();
    }

    public function index()
    {
        // Fetch all pending issues from the database
        $pendingIssues = $this->issueModel->where(['status' => 'pending']);

        // Fetch all solved issues from the database
        $solvedIssues = $this->issueModel->where(['status' => 'solved']);

        // Pass the data to the view
        $this->view('supervisor/issue', [
            'pendingIssues' => $pendingIssues,
            'solvedIssues' => $solvedIssues,
        ]);
    }


    public function markAsSolved($id)
    {
        // Update the status of the issue to 'solved'

        if (!$this->issueModel->update($id, ['status' => 'solved'], 'id')) {
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
