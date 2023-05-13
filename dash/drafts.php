<?php 
require_once 'config/db.php';
require_once 'models/function.php';

$db = new Database();
$db = $db->connect();
$scripts = new scripts($db);


$page = "Drafts";
$id = "draft";
include "templates/header.php"; ?>
<script>
$("#<?php echo $id ?>").attr("class", "nav-item active");
</script>


<!--START OF SECTION 1-->

<!-- DataTales Example -->
<div class="card shadow mb-4">
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
                $pagination = $scripts->draftPagination($_SESSION['id'], $pageno);
                //echo $pagination;
                $pagination = explode("-", $pagination);
                $fLimit = $pagination[0];
                $lLimit = $pagination[1];
                $total_pages = $pagination[2];
                $gp = $scripts->getdraft($_SESSION['id'], $fLimit, $lLimit);
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
                        <td><a href='edit.php?id=".$row['id']."'><button class='btn btn-primary'>Edit</button></a></td>
                        <td><button class='btn btn-success' id='p".$row['id']."' onclick='makeDraft(".$row['id'].")'>Publish</button></td>
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

<!--END OF SECTION 1-->




</div>
<!-- End of Main Content -->
<script>
function makeDraft(id) {
    $("#d" + id).attr("disabled", "disabled");
    $("#d" + id).html("Moving to drafts <i class='fa fa-spinner fa-spin'></i>");
    $.ajax({
        type: "post",
        url: "controllers/convert.controller.php",
        data: {
            convert: "published",
            pid: id
        },
        success: function(result) {
            if (result.includes("Successfully")) {
                $("#row" + id).remove();
                swal("Change Status", result, "success");
                //alert(result);
            } else {
                swal("Change Status", result, "error");
                //alert(result);
            }
        }
    })
}
</script>
<?php include "templates/footer.html"; ?>