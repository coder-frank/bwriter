<?php 
require_once 'config/db.php';
require_once 'models/function.php';

$db = new Database();
$db = $db->connect();
$scripts = new scripts($db);

$page = "Edit Article";
$id = "edit";
include "templates/header.php"; ?>
<script>
$("#<?php echo $id ?>").attr("class", "nav-item active");
</script>

<!--START OF SECTION 1-->
<?php
if(isset($_GET['id'])){
?>
<!--EDIT A SPECIFIC POST-->
<?php
$details = $scripts->getUpdate($_GET['id']);
if (!$details == false) {
    foreach ($details as $key) {
        $title = $key['title'];
        $category = $key['category'];
        $author = $key['author'];
        $body = $key['body'];
    }
} else {
    echo "Post Not Found";
} 
?>

<script src="editor/ckeditor1/ckeditor.js"></script>
<center>
    <div class="form-group row">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <button class="btn btn-success" type="submit" id="update" onclick="update('published', 'update')">Save and
                Publish</button>
        </div>
        <div class="col-sm-6">
            <button class="btn btn-dark" type="submit" id="sad" onclick="update('draft', 'sad')">Save as Draft</button>
        </div>
    </div>
</center>


<div class="form-group row">
    <div class="col-sm-6 mb-3 mb-sm-0">
        <label for="title">Title</label>
        <input type="text" class="form-control form-control-user" id="title" value="<?php echo $title; ?>"
            placeholder="Try Some Facinating Title">
    </div>
    <div class="col-sm-6">
        <label for="category">Category</label>
        <input type="text" class="form-control form-control-user" id="category"
            placeholder="What Category is your article Under" value="<?php echo $category; ?>">
    </div>
</div>


<div class="form-group">
    <label for="author">Author</label>
    <input type="text" class="form-control form-control-user" id="author"
        placeholder="Let Your Viewers Know Who Wrote The Article" value="<?php echo $author; ?>">
</div>


<div class="form-group">
    <label for="editor1">Article Body</label>
    <textarea class="form-control" id="editor1" placeholder="Let Your Thoughts Fly">
    <?php echo $body; ?>
    </textarea>
</div>
<script>
CKEDITOR.replace('editor1');
</script>

<script>
function update(status, id) {
    //DISABLE INPUTS AND BUTTONS
    $(".form-group input").attr("disabled");
    $("#sad").attr("disabled", "true");
    $("#update").attr("disabled", "true");
    $("#exampleFormControlTextarea1").attr("disabled");
    $("#" + id).html("Updating <i class='fa fa-spinner fa-spin'></i>");

    //GET ALL INPUT VALUES
    var title = $("#title").val();
    var category = $("#category").val();
    var author = $("#author").val();
    var body = CKEDITOR.instances['editor1'].getData();
    $.ajax({
        type: "POST",
        url: "controllers/update.controller.php",
        data: {
            update_p: '',
            id: '<?php echo $_GET['id'] ?>',
            status: status,
            title: title,
            category: category,
            author: author,
            body: body
        },
        success: function(data) {
            $(".form-group input").removeAttr("disabled");
            $("#sad").removeAttr("disabled");
            $("#update").removeAttr("disabled");
            $("#exampleFormControlTextarea1").removeAttr("disabled");
            $("#" + id).html("Update and publish");
            swal("Article Updated", data, "success") // show response from the php script.
            //alert(data);
        }
    });
}
</script>

<?php } else { ?>
<!--DISPLAY ALL POST TABLE-->

<!-- DataTales Example -->
<div class=" card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Drafts</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Author</th>
                        <th>Date-Created</th>
                        <th>Status</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>S/N</th>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Author</th>
                        <th>Date-Created</th>
                        <th>Status</th>
                        <th colspan="2">Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                if (isset($_GET['pageno'])) {
                $pageno = $_GET['pageno'];
                } else {
                $pageno = 1; 
                }
                $pagination = $scripts->allPagination($_SESSION['id'], $pageno);
                //echo $pagination;
                $pagination = explode("-", $pagination);
                $fLimit = $pagination[0];
                $lLimit = $pagination[1];
                $total_pages = $pagination[2];
                $gp = $scripts->getAll($_SESSION['id'], $fLimit, $lLimit);
                if ($gp == true) {
                    $count = 1;
                    foreach ($gp as $row) {
                        echo "<tr id='row".$row['id']."'>
                        <td>".$count."</td>
                        <td>".$row['category']."</td>
                        <td>".$row['title']."</td>
                        <td>".$scripts->createDescription($row['body'])."</td>
                        <td>".$row['author']."</td>
                        <td>".$row['created_at']."</td>
                        <td>".ucfirst($row['status'])."</td>
                        <td><a href='edit.php?id=".$row['id']."'><button class='btn btn-primary'>Edit</button></a></td>
                        <td><button class='btn btn-danger' id='delete".$row['id']."' onclick='deleteA(".$row['id'].")'>Delete</button></td>
                        </tr>";
                        $count++;
                    }
                } 
                else {
                    echo "<div class='alert alert-info'>No Article Found</div>";
                }
                    ?>
                </tbody>
            </table>
            <ul class="pagination justify-content-center my-4">
                <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                <li class="page-item <?php if($pageno <= 1){ echo 'disabled'; } ?>">
                    <a class="page-link"
                        href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
                </li>
                <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                    <a class="page-link"
                        href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
                </li>
                <li><a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
            </ul>
        </div>
    </div>
</div>

<?php
    
}

?>




<!--END OF SECTION 1-->
</div>
<!-- End of Main Content -->
<script>
function deleteA(id) {
    if (confirm("Do you want to delete this article?")) {
        $("#delete" + id).attr("disabled", "disabled");
        $("#delete" + id).html("Deleting article <i class='fa fa-spinner fa-spin'></i>");


        $.ajax({
            type: "post",
            url: "controllers/deleteArticle.controller.php",
            data: {
                delete: "",
                pid: id
            },
            success: function(result) {
                if (result.includes("Successfully")) {
                    $("#row" + id).remove();
                    swal("Delete Article --" + result + "  success");
                    //alert(result);
                } else {
                    swal("Delete Article --" + result + "  error");
                    //alert(result);
                }
            }
        })



    } else {
        return;
    }
}
</script>
<?php include "templates/footer.html"; ?>