<?php
/**
 * Manage_sitehead class
 */
class Manage_sitehead
{
    use Controller;

    private $sitehead;

    public function __construct() {
        // Initialize the Sitehead model
        $this->sitehead = new Sitehead();
    }

    public function index()
    {
        // Render the view for managing siteheads
        $this->view('admin/Manage_sitehead');
    }

    public function addsitehead()
    {
        // Initialize an array to hold errors and form data
        $data = [
            'errors' => [], // Initialize errors
            'formData' => [] // Initialize form data
        ];
        
        // Check if the request method is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve form data
            $formData = [
                'name' => $_POST['name'] ?? null,
                'email' => $_POST['email'] ?? null,
                'number' => $_POST['number'] ?? null,
                'zone' => $_POST['zone'] ?? null,
            ];

            // Validate the form data using the model's validation method
            if ($this->sitehead->validate($formData)) {
                // If validation passes, insert the data into the database
                if ($this->sitehead->insert($formData)) {
                    // Redirect to the manage sitehead page or display success message
                    header("Location: " . URLROOT . "/admin/Manage_sitehead");
                    exit;
                } else {
                    $data['errors'][] = "Failed to insert data into the database.";
                }
            } else {
                // If validation fails, capture errors
                $data['errors'] = $this->sitehead->errors;
            }
        }

        // Render the view with the data
        $this->view('admin/Manage_sitehead', $data);
    }
}
?>