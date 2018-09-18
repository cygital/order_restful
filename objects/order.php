<?php
class Order{
	//config property
	public $google_key = 'AIzaSyDtXdLrpezUmH4FH7DCmZXW0jfoIrKLf5Q';
	
    // database properties
    private $conn;
    private $table_name = 'orders';
 
    // object properties
    public $id;
    public $start_latitude;
    public $start_longitude;
	public $end_latitude;
    public $end_longitude;
    public $status = 'UNASSIGN';
    public $created;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// read orders
	function read($page = 1, $limit = 10){
		//start limit form apprioprate record
		$pager = ($page-1)*$limit;
		// select all query
		$query = "SELECT * FROM " . $this->table_name . " limit $pager, $limit";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}
	
	function getStatus(){
		// select query
		$query = "SELECT status FROM " . $this->table_name . " WHERE id = :id";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
		
		$stmt->bindParam(':id', $this->id);
		
		// execute query
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['status'];
	}
	
	// create order
	function create(){
	 
		// query to insert record
		$query = "INSERT INTO " . $this->table_name . " SET start_latitude=:start_latitude, start_longitude=:start_longitude, end_latitude=:end_latitude, end_longitude=:end_longitude, distance=:distance, created=:created";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->start_latitude=htmlspecialchars(strip_tags($this->start_latitude));
		$this->start_longitude=htmlspecialchars(strip_tags($this->start_longitude));
		$this->end_latitude=htmlspecialchars(strip_tags($this->end_latitude));
		$this->end_longitude=htmlspecialchars(strip_tags($this->end_longitude));
		$this->distance=htmlspecialchars(strip_tags($this->distance));
	 
		// bind values
		$stmt->bindParam(":start_latitude", $this->start_latitude);
		$stmt->bindParam(":start_longitude", $this->start_longitude);
		$stmt->bindParam(":end_latitude", $this->end_latitude);
		$stmt->bindParam(":end_longitude", $this->end_longitude);
		$stmt->bindParam(":distance", $this->distance);
		$stmt->bindParam(":created", $this->created);
	 
		// execute query
		if($stmt->execute()){
			return $this->conn->lastInsertId();
		}
	 
		return false;
		 
	}
	
	// Take order
	function update(){
	 
		// update query
		$query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->status=htmlspecialchars(strip_tags($this->status));
		$this->id=htmlspecialchars(strip_tags($this->id));
	 
		// bind new values
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':id', $this->id);
	 
		// execute the query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
	}

}