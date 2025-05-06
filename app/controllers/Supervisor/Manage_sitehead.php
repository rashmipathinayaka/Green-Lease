<?php 

/**
 * home class
 */
class Manage_sitehead
{
	use Controller;
    private $sitehead;

	public function index()
	{
        $supervisorId = $_SESSION['id'] ?? 1;
		$data = $this->sitehead->getSiteheadsBySupervisorUserId($supervisorId);
        $inactiveUsers = $this->sitehead->getInactiveUsers($supervisorId);
        
        // Get any flash messages
        $success = $_SESSION['success_message'] ?? null;
        $error = $_SESSION['error_message'] ?? null;
        
        // Clear flash messages after retrieving them
        unset($_SESSION['success_message']);
        unset($_SESSION['error_message']);
            
        $this->view('supervisor/manage_sitehead', [
            'data' => $data,
            'inactiveUsers' => $inactiveUsers,
            'success' => $success,
            'error' => $error
        ]);
	}

    public function __construct() {
        $this->sitehead = new Sitehead();
    }

    public function add_sitehead() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve form data
            $user_id = $_POST['user_id'] ?? null;
            $land_id = $_POST['land_id'] ?? null;
            
            // Prepare data for validation
            $formData = [
                'user_id' => $user_id,
                'land_id' => $land_id
            ];
            
            // Validate the data
            if ($this->sitehead->validate($formData)) {
                // Check if land is already assigned to an active sitehead
                if ($this->sitehead->isLandAssigned($land_id)) {
                    $_SESSION['error_message'] = "This land is already assigned to an active sitehead.";
                    redirect('supervisor/manage_sitehead');
                    return;
                }
                
                // Get the sitehead record by user_id
                $siteheadRecord = $this->sitehead->getSiteheadByUserId($user_id);
                
                if ($siteheadRecord) {
                    // Update existing sitehead record
                    $updateData = [
                        'land_id' => $land_id,
                        'status' => 'Active'
                    ];
                    
                    // Use the id field for the WHERE clause
                    if ($this->sitehead->update($siteheadRecord->id, $updateData, 'id')) {
                        $_SESSION['success_message'] = "Site head status updated to Active successfully!";
                    } else {
                        $_SESSION['error_message'] = "Failed to update site head status. Please try again.";
                    }
                } else {
                    // This is a new sitehead, insert a new record
                    $insertData = [
                        'user_id' => $user_id,
                        'land_id' => $land_id,
                        'status' => 'Active',
                        'zone' => $this->sitehead->getSupervisorZone($_SESSION['id'] ?? 1)
                    ];
                    
                    if ($this->sitehead->insert($insertData)) {
                        $_SESSION['success_message'] = "Site head assigned successfully!";
                    } else {
                        $_SESSION['error_message'] = "Failed to assign site head. Please try again.";
                    }
                }
            } else {
                // Get validation errors
                $errors = $this->sitehead->errors;
                $_SESSION['error_message'] = implode(", ", $errors);
            }
            
            redirect('supervisor/manage_sitehead');
        }
    }
    

    public function delete_sitehead($id) {
        if ($this->sitehead->delete($id)) {
            $_SESSION['success_message'] = "Site head removed successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to remove site head. Please try again.";
        }
        
        redirect('supervisor/manage_sitehead');
    }
    
    public function update_sitehead() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $updatedata = [
                'land_id' => $_POST['land_id'],
                'status' => $_POST['status']
            ];
            
            // Check if land is already assigned to another active sitehead
            if ($updatedata['status'] == 'Active' && $this->sitehead->isLandAssignedToOther($updatedata['land_id'], $id)) {
                $_SESSION['error_message'] = "This land is already assigned to another active sitehead.";
                redirect('supervisor/manage_sitehead');
                return;
            }
            
            if ($this->sitehead->update($id, $updatedata, 'id')) {
                $_SESSION['success_message'] = "Site head updated successfully!";
            } else {
                $_SESSION['error_message'] = "Failed to update site head. Please try again.";
            }
            
            redirect('supervisor/manage_sitehead');
        }
    }
}
