<?php  
include "includes/database.php";
include "includes/comment.php";


$database = new database();
$db = $database->connect();
$new_comment = new comment($db);


    // Delete category
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        if(isset($_POST['delete'])){
        $new_comment = new comment($db);
        $new_comment->n_blog_comment_id = $_POST['blog_comment_id'];
        
        if($new_comment->delete()){
            $flag = "Delete comment successful!";
        }
        }
    }



?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NVN Comment</title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>

<body>
    <div id="wrapper">
        <?php  
            include "header.php";
        ?>
        <!--/. NAV TOP  -->
        <?php  
            include "sidebar.php";
        ?>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">


                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Comment
                        </h1>
                    </div>
                </div>
                <!-- /. ROW  -->

                <?php 
                    if(isset($flag)){

                ?>
                    <div class="alert alert-success">
                        <strong><?php echo $flag ?></strong>
                    </div>                        
                <?php 
                    }
                ?>

               
                <!-- /. ROW  -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Blogs Comment
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Parent ID</th>
                                                <th>Blog Post ID</th>
                                                <th>Author</th>
                                                <th>Author Email</th>
                                                <th>Comment</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>                                        
                                        <tbody>
                                            <?php  
                                            $result = $new_comment->read();
                                            $num = $result->rowCount();
                                            if($num>0){
                                                while($rows = $result->fetch()){                             
                                            ?>
                                            <tr>
                                                <td><?php echo $rows['n_blog_comment_id'] ?></td>
                                                <td><?php echo $rows['n_blog_comment_parent_id'] ?></td>
                                                <td><?php echo $rows['n_blog_post_id'] ?></td>
                                                <td><?php echo $rows['v_comment_author'] ?></td>
                                                <td><?php echo $rows['v_comment_author_email'] ?></td>
                                                <td><?php echo $rows['v_comment'] ?></td>
                                                <td>
                                                <button class="popup-button">View</button>
                                                <button data-toggle="modal" data-toggle="modal" data-target="#delete_blog<?php echo $rows['n_blog_comment_id']?>">Delete</button>

                                         

                                                <div class="modal fade" id="delete_blog<?php echo $rows['n_blog_comment_id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form method="POST" action="">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title" id="myModalLabel">Delete Comment</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure that you want to delete this comment?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="blog_comment_id" value="<?php echo $rows['n_blog_comment_id']; ?>">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                <button name="delete" type="submit" class="btn btn-primary">Delete</button>
                                                            </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                </td>
                                            </tr> 
                                            <?php  
                                                }        
                                            }
                                            ?>                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel -->
                    </div>
                </div>
                <!-- /. ROW  -->
                
				<footer><p>&copy;2022</p></footer>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- Morris Chart Js -->
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
    <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>


</body>

</html>