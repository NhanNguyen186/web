<?php  
class comment{

	//DB Stuff
	private $conn;
	private $table = "blog_comment";

	//Blog Categories Properties
	public $n_blog_comment_id;
	public $n_blog_comment_parent_id;
	public $n_blog_post_id;
	public $v_comment_author;
	public $v_comment_author_email;
	public $v_comment;
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
		$sql = "SELECT * FROM $this->table WHERE n_blog_comment_id = :get_id";

		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':get_id',$this->n_blog_comment_id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		//Set Properties
		$this->n_blog_comment_id = $row['n_blog_comment_id'];
		$this->n_blog_comment_parent_id=$row['n_blog_comment_parent_id'];
		$this->n_blog_post_id=$row['n_blog_post_id'];
		$this->v_post_meta_title=$row['v_post_meta_title'];
		$this->v_comment_author=$row['v_comment_author'];
		$this->v_comment_author_email=$row['v_comment_author_email'];
		$this->v_comment=$row['v_comment'];
		$this->d_date_created=$row['d_date_created'];
		$this->d_time_created=$row['d_time_created'];
		
	}

	
	//Delete blog_post
	public function delete(){

		//Create query
		$query = "DELETE FROM $this->table
		          WHERE n_blog_comment_id = :get_id";
		
		//Prepare statement
		$stmt = $this->conn->prepare($query);

		//Clean data
		$this->n_blog_comment_id = htmlspecialchars(strip_tags($this->n_blog_comment_id));

		//Bind data
		$stmt->bindParam(':get_id',$this->n_blog_comment_id);

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

