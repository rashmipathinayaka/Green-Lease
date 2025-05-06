<?php 
class RReprot{
    use Model;
    private $db;
   



    public function mostseletectedcrop() {
        $query = "SELECT crop_type, COUNT(*) AS count
                  FROM project
                  GROUP BY crop_type
                  ORDER BY count DESC
                  LIMIT 1";
        
        $result = $this->query($query);
        
        if (!empty($result)) {
            return [
                'crop_type' => $result[0]->crop_type,
                'count' => $result[0]->count
            ];
        }
        
        return null;
        
     
    }


    public function mostprefferedcrop() {
        $query = "SELECT crop_type, COUNT(*) AS count
                  FROM land
                  GROUP BY crop_type
                  ORDER BY count DESC
                  LIMIT 1";
        
        $result = $this->query($query);
        
        if (!empty($result)) {
            return [
                'crop_type' => $result[0]->crop_type,
                'count' => $result[0]->count
            ];
        }
        
        return null;
        
     
}


public function getMatchingCropCount() {
    $query = "SELECT l.crop_type, COUNT(*) AS match_count
              FROM land l
              INNER JOIN project p ON l.crop_type = p.crop_type
              GROUP BY l.crop_type";
    
    return $this->query($query)[0];
}


public function totalprojects(){
 
        $query = "SELECT COUNT(*) AS totalprojects FROM project";
        $result = $this->query($query);
        
        return $result[0]->totalprojects ?? 0;
    }


    public function mostlandzone() {
        $query = "SELECT z.zone_name, COUNT(*) AS count
                  FROM land l
                  INNER JOIN zone z ON l.zone = z.id
                  GROUP BY z.zone_name
                  ORDER BY count DESC
                  LIMIT 1";
    
        $result = $this->query($query);
        
        if (!empty($result)) {
            return [
                'zone_name' => $result[0]->zone_name,
                'count' => $result[0]->count
            ];
        }
        
        return null;
    }
    

public function mostlandyear(){
    $query = "SELECT registered_date, COUNT(*) AS count
              FROM land
              GROUP BY registered_date
              ORDER BY count DESC
              LIMIT 1";
    
    $result = $this->query($query);
    
    if (!empty($result)) {
        return [
            'registered_date' => $result[0]->registered_date,
            'count' => $result[0]->count
        ];
    }
    
    return null;

}


public function countbuyers() {
    $query = "SELECT COUNT(*) AS buyer_count FROM user WHERE role_id = 5";
    $result = $this->query($query);
    
    return $result[0]->buyer_count ?? 0;

}


public function countPostponedEventsThisYear() {
    $currentYear = date('Y');

    $query = "SELECT count(*) AS postponedCount
              FROM event
              WHERE postponed = 'yes' AND YEAR(date) = $currentYear";

    
    $result = $this->query($query);

    
    if ($result) {
        return $result[0]->postponedCount; 
    } else {
        return 0; 
    }
}



public function gettotalevents(){

    $currentYear = date('Y');


$query="SELECT count(*) as totalevents from event where YEAR(date) = $currentYear";

$result=$this->query($query);

return $result[0]->totalevents;


}












}








