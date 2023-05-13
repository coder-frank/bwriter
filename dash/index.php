<?php 
require_once 'config/db.php';
require_once 'models/function.php';

$db = new Database();
$db = $db->connect();
$scripts = new scripts($db);

$page = "Dashboard";
$id = "dash";
include "templates/header.php"; 
?>
<script>
$("#<?php echo $id ?>").attr("class", "nav-item active");
</script>

<!--START OF SECTION ONE(1)-->
<div class="row">

    <!-- Users Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Articles</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo $scripts->postCount($_SESSION['id']); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Articles Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Drafts </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo $scripts->getTotalDraft($_SESSION['id']); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Views
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    <?php echo $scripts->getViews($_SESSION['id']); ?>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-eye fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Subscribers</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo $scripts->getTotalSubscribers($_SESSION['id']); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-rocket fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--END OF SECTION ONE(1)-->



<!--START OF SECTION TWO(2) -->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Published Articles</h6>
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
                        <th>Views</th>
                        <th>Comments</th>
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
                        <th>Views</th>
                        <th>Comments</th>
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
                $pagination = $scripts->pagination($_SESSION['id'], $pageno);
                //echo $pagination;
                $pagination = explode("-", $pagination);
                $fLimit = $pagination[0];
                $lLimit = $pagination[1];
                $total_pages = $pagination[2];
                $gp = $scripts->getAllPost($_SESSION['id'], $fLimit, $lLimit);
                if ($gp == true) {
                    $count = 1;
                    foreach ($gp as $row) {
                        echo "<tr id='row".$row['id']."'>
                        <td>".$count."</td>
                        <td>".$row['category']."</td>
                        <td>".$row['title']."</td>
                        <td>".$scripts->createDescription($row['body'])."</td>
                        <td>".$row['author']."</td>
                        <td><i class='fa fa-eye'></i>&nbsp;&nbsp;(".$scripts->getSingleView($_SESSION['id'], $row['id']).")</td>
                        <td><i class='fa fa-comment'></i>&nbsp;&nbsp;(".$scripts->getTotalComment($row['id']).")</td>
                        <td>".$row['created_at']."</td>
                        <td><a href='../".$_SESSION['blogLink'].'/'.$row['link']."' target='_blank'><button class='btn btn-primary'>View Post</button></a></td>
                        <td><button class='btn btn-dark' id='p".$row['id']."' onclick='makeDraft(".$row['id'].")'>Move to drafts</button></td>
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

<!--END OF SECTION TWO(2)-->





</div>
<!-- End of Main Content 
-->
<script>
function makeDraft(id) {
    $("#p" + id).attr("disabled", "disabled");
    $("#p" + id).html("Moving to drafts <i class='fa fa-spinner fa-spin'></i>");
    $.ajax({
        type: "post",
        url: "controllers/convert.controller.php",
        data: {
            convert: "draft",
            pid: id
        },
        success: function(result) {
            if (result.includes("Successfully")) {
                $("#row" + id).remove();
                swal("Change Status", result, "success")
            } else {
                swal("Change Status", result, "error")
            }
        }
    })
}
</script>
<?php include "templates/footer.html"; ?>