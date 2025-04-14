<?php 

// Trait Database
// {

// 	private function connect()
// 	{
// 		$string = "mysql:hostname=".DBHOST.";dbname=".DBNAME;
// 		$con = new PDO($string,DBUSER,DBPASS);
// 		return $con;
// 	}

// 	public function query($query, $data = [])
// 	{

// 		$con = $this->connect();
// 		$stm = $con->prepare($query);

// 		$check = $stm->execute($data);
// 		if($check)
// 		{
// 			$result = $stm->fetchAll(PDO::FETCH_OBJ);
// 			if(is_array($result) && count($result))
// 			{
// 				return $result;
// 			}
// 		}

// 		return false;
// 	}

// 	public function getrow($query, $data = [])
// 	{

// 		$con = $this->connect();
// 		$stm = $con->prepare($query);

// 		$check = $stm->execute($data);
// 		if($check)
// 		{
// 			$result = $stm->fetchAll(PDO::FETCH_OBJ);
// 			if(is_array($result) && count($result))
// 			{
// 				return $result[0];
// 			}
// 		}

// 		return false;
// 	}
	

// 	public function bind($param, $value, $type = null)
//     {
//         $con = $this->connect();
//         $stm = $con->prepare("SELECT 1");
//         // Bind the value to the specified parameter
//         if (is_null($type)) {
//             $type = PDO::PARAM_STR;  // Default type is string
//         }
//         $stm->bindValue($param, $value, $type);
//     }



// 	public function single()
//     {
//         $con = $this->connect();
//         $stm = $con->prepare("SELECT 1");
//         $result = $stm->fetch(PDO::FETCH_OBJ);
//         return $result;
//     }









//}



Trait Database
{
    // Method to connect to the database
    private function connect()
    {
        $string = "mysql:hostname=" . DBHOST . ";dbname=" . DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);
        return $con;
    }

    // Method to run a query and return multiple results
    public function query($query, $data = [])
    {
        $con = $this->connect();
        $stm = $con->prepare($query);

        // Execute the query with the provided data (bindings)
        $check = $stm->execute($data);
        if ($check) {
            // Fetch all the results as an array of objects
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            if (is_array($result) && count($result)) {
                return $result;
            }
        }

        return false;
    }

    // Method to fetch a single row from a query
    public function getrow($query, $data = [])
    {
        $con = $this->connect();
        $stm = $con->prepare($query);

        // Execute the query with the provided data
        $check = $stm->execute($data);
        if ($check) {
            // Fetch the first result
            $result = $stm->fetch(PDO::FETCH_OBJ); // Fetch a single row
            if ($result) {
                return $result;
            }
        }

        return false;
    }

    // Method to bind a value to a parameter in a prepared statement
    public function bind($stm, $param, $value, $type = null)
    {
        // Default to string type if none is provided
        if (is_null($type)) {
            $type = PDO::PARAM_STR;
        }

        // Bind the value to the parameter
        $stm->bindValue($param, $value, $type);
    }

    // Method to get a single result from the query
    public function single($query, $data = [])
    {
        $con = $this->connect();
        $stm = $con->prepare($query);
        $stm->execute($data); // Execute with provided data
        $result = $stm->fetch(PDO::FETCH_OBJ);
        return $result;
    }
}
