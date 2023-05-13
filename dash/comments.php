<?php 
require_once 'config/db.php';
require_once 'models/function.php';

$db = new Database();
$db = $db->connect();
$scripts = new scripts($db);


$page = "Comments";
$id = "comment";
include "templates/header.php"; ?>
<script>
$("#<?php echo $id ?>").attr("class", "nav-item active");
</script>


<!--START OF SECTION 1-->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Comments</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Title</th>
                        <th>Name</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>S/N</th>
                        <th>Title</th>
                        <th>Name</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                if (isset($_GET['pageno'])) {
                $pageno = $_GET['pageno'];
                } else {
                $pageno = 1; 
                }
                $pagination = $scripts->commentPagination($_SESSION['id'], $pageno);
                $pagination = explode("-", $pagination);
                $fLimit = $pagination[0];
                $lLimit = $pagination[1];
                $total_pages = $pagination[2];
                
                $postA = $scripts->mergeCommentAndPost($fLimit, $lLimit);
                
                if ($postA == false) {
                    echo "<div class='alert alert-primary'>No Comments Available</div>";
                } else {
                    $count = 0;
                    $counter = 0;
                    foreach ($postA as $row) {
                        $count++;
                        ?>
                    <tr id='row<?php echo $row['id'];?>'>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row['title'];?></td>
                        <td><?php echo $row['fullname']; ?></td>
                        <td><?php echo $row['message']; ?></td>
                        <td><?php echo $row['date_created']; ?></td>
                        <td><button class='btn btn-danger' id='d<?php echo $row['id']; ?>'
                                onclick="deleteC(<?php echo $row['id']; ?>)">Delete</button>
                        </td>
                    </tr>
                    <?php
                    }
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

<!--END OF SECTION 1-->



</div>
<!-- End of Main Content -->
<script>
function deleteC(id) {
    if (confirm("Are You Sure You Want To Delete This Comment ?")) {

        $("#d" + id).attr("disabled", "disabled");
        $("#d" + id).html("Deleting Comment <i class='fa fa-spinner fa-spin'></i>");


        $.ajax({
            type: "post",
            url: "controllers/deleteComment.controller.php",
            data: {
                delete: "",
                cid: id
            },
            success: function(result) {
                if (result.includes("Successfully")) {
                    swal("Delete Comment", result, "success");
                    //alert(result);
                    $("#row" + id).remove();
                } else {
                    //alert(result);
                    swal("Delete Comment", result, "error")
                }
            }
        })
    }
}
</script>
<?php include "templates/footer.html"; ?>