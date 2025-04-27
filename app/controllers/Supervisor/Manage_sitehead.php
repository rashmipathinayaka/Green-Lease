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
        $data = $this->sitehead->getAllSiteheads('1');  
        $inactiveUsers = $this->sitehead->getInactiveUsers(); // Get inactive users from users table

        $this->view('Supervisor/Manage_sitehead', [
            'data' => $data,
            'inactiveUsers' => $inactiveUsers

        ]);
    }
    public function add_sitehead()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_POST['user_id'] ?? null;
            $land_id = $_POST['land_id'] ?? null;
            $full_name = $_POST['full_name'] ?? null;

            if ($this->sitehead->isLandAssigned($land_id)) {
                // Set error message and return
                $this->view('supervisor/manage_sitehead', [
                    'error' => "This land is already assigned to an active sitehead.",
                    'inactiveUsers' => $this->sitehead->getInactiveUsers(),
                    'data' => $this->sitehead->getAllSiteheads('1')
                ]);
                return;
            }

        
            // Step 1: Validate input
            $formData = [
                'user_id' => $user_id,
                'land_id' => $land_id,
                'full_name' =>$full_name,
                'status' => 'Active' // Now setting status to Active
            ];
    
            if ($this->sitehead->validate($formData)) {
                // Step 2: Update user table
                
    
                // Step 3: Update sitehead record with land_id and set status to active
                $this->sitehead->update($user_id, [
                    'land_id' => $land_id,
                    'status' => 'Active',
                ], 'user_id'); // assuming user_id is the key for updating
                

                // Step 4: Optionally assign land to a project for this sitehead
                //$supervisorId = $_SESSION['id'];
                $supervisor_id = 1; // hardcoded or get it dynamically from session
                $this->sitehead->assignLandToSitehead($land_id, $supervisor_id);
    
                // Step 5: Reload view with updated data
                $data = $this->sitehead->getAllSiteheads('1');
                $inactiveUsers = $this->sitehead->getInactiveUsers();
    
                $this->view('Supervisor/Manage_sitehead', [
                    'data' => $data,
                    'inactiveUsers' => $inactiveUsers,
                    'success' => "Sitehead assigned successfully!"
                ]);
                
            } else {
                echo "Validation failed.";
            }
        }
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
                'user_id' => $_POST['user_id'],
                'land_id' => $_POST['land_id'],
                'status' => $_POST['status']
            ];

            $this->sitehead->update($id, $updatedata, 'id');

            $newdata = $this->sitehead->getAllSiteheads(1);  // Fetch with pagination
            $inactiveUsers = $this->sitehead->getInactiveUsers();
            $this->view('supervisor/manage_sitehead', [
                'data' => $newdata,
                'inactiveUsers' => $inactiveUsers
            ]);
        }
    }
}   
