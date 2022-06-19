<?php  
class contact{

	//DB Stuff
	private $conn;
	private $table = "blog_contact";

	//Blog Categories Properties
	public $n_contact_id;
	public $v_fullname;
	public $v_email;
	public $v_phone;
	public $v_message;
	public $f_contact_status;
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
		$sql = "SELECT * FROM $this->table WHERE n_contact_id = :get_id";

		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':get_id',$this->n_contact_id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		//Set Properties
		$this->n_contact_id = $row['n_contact_id'];
		$this->v_email=$row['v_email'];
		$this->v_phone=$row['v_phone'];
		$this->v_fullname=$row['v_fullname'];
		$this->v_message=$row['v_message'];
		$this->f_contact_status =$rows['f_contact_status'];
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
		          SET v_fullname =:fullname,
		          v_email = :sub_email,
		          v_phone =:phone,
		          v_message=:message;
		          	f_contact_status =:contact_status,
		          	  d_date_created = :date_created,
		          	  d_time_created = :time_created";			
		//Prepare statement
		$stmt = $this->conn->prepare($query);

		//Clean data
	/*	$this->v_blog_post_title = htmlspecialchars(strip_tags($this->v_blog_post_title));
		$this->v_blog_post_meta_title = htmlspecialchars(strip_tags($this->v_blog_post_meta_title));
		$this->v_blog_post_path = htmlspecialchars(strip_tags($this->v_blog_post_path));*/

		//Bind data
		$stmt->bindParam(':v_email',$this->v_email);
		$stmt->bindParam(':f_contact_status',$this->f_contact_status);
		$stmt->bindParam(':v_phone',$this->v_phone);
		$stmt->bindParam(':v_message',$this->v_message);
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
		          SET n_contact_id = :contact_id,
						v_email = :email,
						f_contact_status =:contact_status,
						v_phone=:phone,
						v_message=:message,
						d_date_created = :date_created,
						d_time_created = :time_created,

		          WHERE 
		          	  n_contact_id = :get_id";
		//Prepare statement
		$stmt = $this->conn->prepare($query);
		//Clean data
		$this->v_email = htmlspecialchars(strip_tags($this->v_email));
		//Bind data
		$stmt->bindParam(':get_id',$this->n_contact_id);
		$stmt->bindParam(':email',$this->v_email);
		$stmt->bindParam(':contact_status',$this->f_contact_status);
		$stmt->bindParam(':message',$this->v_message);
		$stmt->bindParam(':phone',$this->v_phone);
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
		          WHERE n_contact_id = :get_id";
		
		//Prepare statement
		$stmt = $this->conn->prepare($query);

		//Clean data
		$this->n_contact_id = htmlspecialchars(strip_tags($this->n_contact_id));

		//Bind data
		$stmt->bindParam(':get_id',$this->n_contact_id);

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

