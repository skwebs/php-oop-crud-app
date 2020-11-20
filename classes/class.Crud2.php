<?php
error_reporting(E_ALL);ini_set("display_errors", 1);
class Crud{
//	private $conn = false; // Check to see if the connection is active
	private $result = array(); // Any results from a query will be stored here
	private $myQuery = ""; // used for debugging process with SQL return
	private $numResults = ""; // used for returning the number of rows
	//
	// Function to make connection to database
	// Change following details fro your connection. 
	// DONT KEEP SQUARE BRACKETS i.e. '[]'
	// private $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);
	protected static $connection;
	protected $pdo;
	
	private $host = "localhost";
	private $user = "root";
	private $pw = "";
	private $db = "test";
	
public function __construct() {
    try {
        // Try and connect to the database
        if (!isset($this->pdo)) {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pw);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        }
    } catch (PDOException $e) {
        echo "There is some problem in connection: " . $e->getMessage();
    }
}
public function __destruct() {
    try {
        // Try and connect to the database
        if (isset($this->pdo)) {
            $this->pdo = null;
        }
    } catch (PDOException $e) {
        echo "There is some problem in connection: " . $e->getMessage();
    }
}

/*	public function connect{
		try {
			$this->pdo = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pw);
			// set the PDO error mode to exception
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			echo "Connected successfully";
			return $this->pdo;
		} catch(PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}
	}*/
	

    // Function to insert into the database
    public function insert($table, $params = array()) {
        // Check to see if the table exists
        if ($this->tableExists($table)) {
            $sql = "INSERT INTO " . $table . " (" . implode(", ", array_keys($params)) . ") VALUES ('" . implode("', '", $params) . "')";
            $this->myQuery = $sql; // Pass back the SQL
            // Make the query to insert to the database
            try {
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                array_push($this->result, $this->pdo->lastInsertId());
                return true; // The data has been inserted
            } catch (PDOException $exception) {
                array_push($this->result, $exception->getMessage());
                return false; // The data has not been inserted                
            }
        } else {
            return false; // Table does not exist
        }
    }

    // Function to SELECT from the database
    public function select($table, $rows = '*', $join = null, $where = null, $order = null, $limit = null) {
        // Create query from the variables passed to the function
        $q = 'SELECT ' . $rows . ' FROM ' . $table;
        if ($join != null) {
            $q .= ' JOIN ' . $join;
        }
        if ($where != null) {
            $q .= ' WHERE ' . $where;
        }
        if ($order != null) {
            $q .= ' ORDER BY ' . $order;
        }
        if ($limit != null) {
            $q .= ' LIMIT ' . $limit;
        }
        // Check to see if the table exists
        if ($this->tableExists($table)) {
            $this->myQuery = $q; // Pass back the SQL
            $stmt = $this->pdo->prepare($q);
            $stmt->execute();
            $this->numResults = $stmt->rowCount();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($this->result, $row);
            }
            return true;
        } else {
            return false; // Table does not exist
        }
    }

    // Function to update row in database
    public function update($table, $params = array(), $where) {
        // Check to see if table exists
        if ($this->tableExists($table)) {
            // Create Array to hold all the columns to update
            $args = array();
            foreach ($params as $field => $value) {
                // Seperate each column out with it's corresponding value
                $args[] = $field . "='" . $value . "'";
            }
            // Create the query
            $sql = 'UPDATE ' . $table . ' SET ' . implode(',', $args) . ' WHERE ' . $where;
            // Make query to database
            $this->myQuery = $sql; // Pass back the SQL
            try {
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                array_push($this->result, $stmt->rowCount());
                return true; // Update has been successful
            } catch (PDOException $exception) {
                array_push($this->result, $exception->getMessage());
                return false; // Update has not been successful
            }
        } else {
            return false; // The table does not exist
        }
    }


    //Function to delete table or row(s) from database
    public function delete($table, $where = null) {
        // Check to see if table exists
        if ($this->tableExists($table)) {
            // The table exists check to see if we are deleting rows or table
            if ($where == null) {
                $delete = 'DELETE ' . $table; // Create query to delete table
            } else {
                $delete = 'DELETE FROM ' . $table . ' WHERE ' . $where; // Create query to delete rows
            }
            // Submit query to database
            try {
                $stmt = $this->pdo->prepare($delete);
                $stmt->execute();
                array_push($this->result, $stmt->rowCount());
                $this->myQuery = $delete; // Pass back the SQL
                return true; // Update has been successful
            } catch (PDOException $exception) {
                array_push($this->result, $exception->getMessage());
                return false; // Update has not been successful
            }
        } else {
            return false; // The table does not exist
        }
    }

// Private function to check if table exists for use with queries
public function tableExists($table) {
    // Try a select statement against the table
    // Run it in try/catch in case PDO is in ERRMODE_EXCEPTION.
    try {
        //$result = $this->con->query("select top 1 * from $table");
		    $result = $this->pdo->query("select 1 from $table limit 1");
    } catch (Exception $e) {
        // We got an exception == table not found
        echo "<hr>".$e->getMessage();
        return FALSE;
    }
    // Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
    return $result !== FALSE;
}


    // Public function to return the data to the user
    public function getResult() {
        $val = $this->result;
        $this->result = array();
        return $val;
    }

    //Pass the SQL back for debugging
    public function getSql() {
        $val = $this->myQuery;
        $this->myQuery = array();
        return $val;
    }

    //Pass the number of rows back
    public function numRows() {
        $val = $this->numResults;
        $this->numResults = array();
        return $val;
    }

}





?>