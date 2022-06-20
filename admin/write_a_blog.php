<?php  
include "includes/database.php";
include "includes/categories.php";
include "includes/blogs.php";

$database =new database();
$db=$database->connect();
$new_blog= new blog($db);

if(isset($_POST['write_blog'])){
    $target_file="../images/upload/";
    if(!empty($_FILES['main_image']['name'])){
        $main_image=$_FILES['main_image']['name'];
        move_uploaded_file($_FILES['main_image']['tmp_name'],$target_file.$main_image);
    }
    else{
        $main_image="";
    }

    if(!empty($_FILES['alt_image']['name'])){
        $alt_image=$_FILES['alt_image']['name'];
        move_uploaded_file($_FILES['alt_image']['tmp_name'],$target_file.$alt_image);
    }
    else{
        $alt_image="";
    }
    $opt=empty($_POST['opt_place'])?0:$_POST['opt_place'];

        $new_blog->n_category_id = $_POST['select_category'];
        $new_blog->v_post_title = $_POST['title'];
        $new_blog->v_post_meta_title = $_POST['meta_title'];
        $new_blog->v_post_path = $_POST['blog_path'];
        $new_blog->v_post_summary = $_POST['blog_summary'];
        $new_blog->v_post_content = $_POST['blog_content'];
        $new_blog->v_main_image_url = $main_image;
        $new_blog->v_alt_image_url = $alt_image;
        $new_blog->n_blog_post_views = 0;
        $new_blog->f_post_status = 1;
        $new_blog->n_home_page_place = $opt;
        $new_blog->d_date_created = date("Y-m-d",time());
        $new_blog->d_time_created = date("h:i:s",time());
       
       if(null !== ($new_blog->create())){
        $flag="Write Successfully";
       }

       //write a blog tag
        $new_tag= new tag($db);
        $new_tag->n_blog_post_id=$new_tag->last_id();
        $new_tag->v_tag=$_POST['blog_tags'];
        $new_tag->create();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NVN Write </title>
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
    <!-- include summernote  css/js   --> 
    <link rel="stylesheet"  href="summernote/summernote.min.css">
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
                           Write a Blog 
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

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Write a Blog
                            </div>
                            <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                     <form role="form" method="POST" action="blogs.php" enctype="multipart/form-data">
                                       
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input name="title"  class="form-control" placeholder="Enter category">
                                        </div>

                                        <div class="form-group">
                                            <label>Meta Title</label>
                                            <input name="meta_title" 
                                            class="form-control" placeholder="Enter meta category">
                                        </div>

                                        <?php  
                                        $cate = new category($db);
                                        $result = $cate->read();
                                        ?>
                                        <div class="form-group">
                                            <label>Blog Categories</label>
                                            <select name="select_category" class="form-control">
                                                <?php  
                                                while($rs = $result->fetch()){
                                                ?>
                                                <option value="<?php echo $rs['n_category_id'] ?>" >
                                                    <?php echo $rs['v_category_title'] ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Main Image</label>
                                            <input type="file" name="main_image">
                                        
                                        </div>


                                        <div class="form-group">
                                            <label>Alt Image</label>
                                            <input type="file" name="alt_image">
                                           
                                        </div>

                                        <div class="form-group" >
                                            <label>Summary</label>
                                            <textarea id="summernote_summary" name="blog_summary" class="form-control" rows="3"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Blog Content</label>
                                            <textarea id="summernote_content" name="blog_content" class="form-control" rows="3"></textarea>
                                        </div>

                                       
                                        <div class="form-group">
                                            <label>Blog Tags (separated by comma)</label>
                                            <input name="blog_tags"  class="form-control" placeholder="Enter path category">
                                        </div>

                                        <div class="form-group">
                                            <label>Blog Path</label>
                                            <input name="blog_path"  class="form-control" placeholder="Enter path category">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Home Page Placement</label>
                                            <label class="radio-inline">
                                                <input type="radio" name="opt_place" id="optionsRadiosInline1" value="1" 
                                                >1
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="opt_place" id="optionsRadiosInline2" value="2"
                                               >2
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="opt_place" id="optionsRadiosInline3" value="3"
                                               >3
                                            </label>
                                        </div>
                                       
                                        <button type="submit" name="write_blog" class="btn btn-default">Write a Blog</button>
                                        
                                    </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                
                            </div>
                            <!-- /.row (nested) -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                </div>
                <!-- /. ROW  -->

                
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
    <!-- khai bao javascript va jquery -->
    <script src="summernote/summernote.min.js"></script>
    <script >
        $('#summernote_summary').summernote({
            placeholder:'Blog summary',
            height:100
        });
        $('#summernote_content').summernote({
            placeholder:'Blog content',
            height:200
        });
    </script>
</body>

</html>