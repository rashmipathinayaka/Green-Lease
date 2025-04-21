<?php 

class Manage_sitehead
{
    use Controller;

    private $sitehead;

    public function __construct() {
        $this->sitehead = new Sitehead();
    }

    public function index()
    {
        // Fetch paginated siteheads (limit 10 per page, starting from page 0)
        $data = $this->sitehead->getAllSiteheads(10, 0);  
        $inactiveUsers = $this->sitehead->getInactiveUsers(); // Get inactive users from users table

        $this->view('Supervisor/Manage_sitehead', [
            'data' => $data,
            'inactiveUsers' => $inactiveUsers
        ]);
    }

    public function manage_sitehead()
    {
        // Fetch inactive users
        $inactiveUsers = $this->sitehead->getInactiveUsers(); 

        $data = [
            'inactiveUsers' => $inactiveUsers
        ];

        // Pass the data to the view
        $this->view('supervisor/manage_sitehead', $data);
    }

    public function add_sitehead()
   {
	
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formData = [
                'user_id' => $_POST['user_id'] ?? null,
                'land_id' => $_POST['land_id'] ?? null,
                'status' => 1 // Force status to Inactive
            ];

            // Validate the input data
            if ($this->sitehead->validate($formData)) {
                $this->sitehead->insert($formData);
            } else {
                echo "Validation failed.";
                return;
            }
        }

        // Reload the data and view after insertion
        $data = $this->sitehead->getAllSiteheads(10, 0);  // Fetch with pagination
        $inactiveUsers = $this->sitehead->getInactiveUsers();
        $this->view('Supervisor/Manage_sitehead', [
            'data' => $data,
            'inactiveUsers' => $inactiveUsers
        ]);
    }

    public function delete_sitehead($id)
    {
        if ($this->sitehead->delete($id)) {
            $data = $this->sitehead->getAllSiteheads(10, 0);  // Fetch with pagination
            $inactiveUsers = $this->sitehead->getInactiveUsers();
            $this->view('supervisor/manage_sitehead', [
                'data' => $data,
                'inactiveUsers' => $inactiveUsers
            ]);
        } else {
            $this->view('_404');
        }
    }

    public function update_sitehead()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $updatedata = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'number' => $_POST['number'],
                'landID' => $_POST['landID'],
                'status' => $_POST['status']
            ];

            $this->sitehead->update($id, $updatedata, 'id');

            $newdata = $this->sitehead->getAllSiteheads(10, 0);  // Fetch with pagination
            $inactiveUsers = $this->sitehead->getInactiveUsers();
            $this->view('supervisor/manage_sitehead', [
                'data' => $newdata,
                'inactiveUsers' => $inactiveUsers
            ]);
        }
    }
}   
