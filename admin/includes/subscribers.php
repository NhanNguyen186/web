<?php  
class subscribers{

	//DB Stuff
	private $conn;
	private $table = "blog_subscriber";

	//Blog Categories Properties
	public $n_sub_id;
	public $v_sub_email;
	public $f_sub_status;
	public $d_date_created;
	public $d_time_created;



	//Constructor with DB
	public function __construct($db){
		$this->conn = $db;
	}

	//Read multi records
	public function read(){
		$sql = "SELECT * FROM $this->table";

		$stmt = $this->conn->prepare($sql);
		$stmt->execute();

		return $stmt;
	}

	//Read one record
	public function read_single(){
		$sql = "SELECT * FROM $this->table WHERE n_sub_id = :get_id";

		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':get_id',$this->n_sub_id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		//Set Properties
		$this->n_sub_id = $row['n_sub_id'];
		$this->v_sub_email=$row['v_sub_email'];
		$this->f_sub_status =$rows['f_sub_status'];
		$this->d_date_created=$row['d_date_created'];
		$this->d_time_created=$row['d_time_created'];
		
	}
	//last id
	/*	public function last_id(){
		$sql="SELECT MAX(n_blog_comment_id) FROM $this->table";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		return $stmt;
	}*/

	//Create blog_post
	public function create(){
		//Create query
		$query = "INSERT INTO $this->table
		          SET v_sub_email = :sub_email,
		          	f_sub_status =:sub_status,
		          	  d_date_created = :date_created,
		          	  d_time_created = :time_created";			
		//Prepare statement
		$stmt = $this->conn->prepare($query);

		//Clean data
	/*	$this->v_blog_post_title = htmlspecialchars(strip_tags($this->v_blog_post_title));
		$this->v_blog_post_meta_title = htmlspecialchars(strip_tags($this->v_blog_post_meta_title));
		$this->v_blog_post_path = htmlspecialchars(strip_tags($this->v_blog_post_path));*/

		//Bind data
		$stmt->bindParam(':v_sub_email',$this->v_sub_email);
		$stmt->bindParam(':v_sub_status',$this->v_sub_status);
		$stmt->bindParam(':date_created',$this->d_date_created);
		$stmt->bindParam(':time_created',$this->d_time_created);

		//Execute query
		if($stmt->execute()){
			return true;
		}
		//Print error if something goes wrong
		printf("Error: %s. \n", $stmt->error);
		return false;
	}

	//Update blog_post
	public function update(){
		//Create query
		$query = "UPDATE $this->table
		          SET n_sub_id = :sub_id,
						v_sub_email = :sub_email,
						f_sub_status =:sub_status,
						d_date_created = :date_created,
						d_time_created = :time_created,

		          WHERE 
		          	  n_sub_id = :get_id";
		//Prepare statement
		$stmt = $this->conn->prepare($query);
		//Clean data
		$this->v_sub_email = htmlspecialchars(strip_tags($this->v_sub_email));
		//Bind data
		$stmt->bindParam(':get_id',$this->n_sub_id);
		$stmt->bindParam(':sub_email',$this->v_sub_email);
		$stmt->bindParam(':sub_status',$this->f_sub_status);
		$stmt->bindParam(':date_created',$this->d_date_created);
		$stmt->bindParam(':time_created',$this->d_time_created);
		//Execute query
		if($stmt->execute()){
			return true;
		}
		//Print error if something goes wrong
		printf("Error: %s. \n", $stmt->error);
		return false;
	}

	//Delete blog_post
	public function delete(){

		//Create query
		$query = "DELETE FROM $this->table
		          WHERE n_sub_id = :get_id";
		
		//Prepare statement
		$stmt = $this->conn->prepare($query);

		//Clean data
		$this->n_sub_id = htmlspecialchars(strip_tags($this->n_sub_id));

		//Bind data
		$stmt->bindParam(':get_id',$this->n_sub_id);

		//Execute query
		if($stmt->execute()){
			return true;
		}

		//Print error if something goes wrong
		printf("Error: %s. \n", $stmt->error);
		return false;

	}
}
?>

