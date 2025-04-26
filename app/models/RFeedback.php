<?php
 class RFeedback{
use Model;

protected $table = 'project_feedback';

protected $allowedColumns =[
    'id',
    'feedback_user_id',
    'remark_user_id',
    'project_id',
    'feedback',
'is_solved',

];



public function getunsolvedFeedbacks() {
    $query = "SELECT pf.*, u.role_id 
    FROM project_feedback pf
    JOIN user u ON pf.feedback_user_id = u.id
    WHERE pf.is_solved = '0' AND pf.is_delete = '0'
";
    return $this->query($query);

}


public function getsolvedFeedbacks() {
    $query = "SELECT pf.*, u.role_id 
    FROM project_feedback pf
    JOIN user u ON pf.remark_user_id = u.id
    WHERE pf.is_solved = 1
     AND pf.is_delete = '0'";
return $this->query($query);
}





public function markAsSolved($feedbackId, $userId, $remark) {
    $query = "UPDATE project_feedback 
              SET is_solved = 1, 
                  remark_user_id = ?, 
                  remark = ?
              WHERE id = ?";
    return $this->query($query, [$userId, $remark, $feedbackId]);
}



public function deleteFeedback($feedbackId) {
        $query = "UPDATE  project_feedback SET is_delete=1 WHERE id = ?";
        return $this->query($query, [$feedbackId]);
    }





 }
 


 