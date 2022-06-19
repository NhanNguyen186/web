<?php  
class database{

	//DB Params
	private $dns = "mysql:host=bsrmfvqehs1ovj9l7fne-mysql.services.clever-cloud.com;dbname=bsrmfvqehs1ovj9l7fne";
	private $username = "uzea0cfs7lmx2gsv";
	private $password = "sqoB7Do0G4qUrDcdoe2R";
	private $conn;

	//DB Connect
	public function connect(){
		$this->conn = null;
		try{
			$this->conn = new PDO($this->dns,$this->username,$this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		}catch(PDOException $e){
			echo "Connection failed: ".$e->getMessage();
		}

		return $this->conn;
	}
}
?>

