<?php 
require_once 'config/db.php';
require_once 'models/function.php';

$db = new Database();
$db = $db->connect();
$scripts = new scripts($db);

$page = "Newsletter Subscribers";
$id = "subscribers";
include "templates/header.php"; ?>
<script>
$("#<?php echo $id ?>").attr("class", "nav-item active");
</script>


<!--START OF SECTION ONE(1)-->
<script src="editor/ckeditor1/ckeditor.js"></script>

<div class="form-group" style="float: right;">
    <button class=" btn btn-success" type="submit" id="publish">Send Email</button>
</div>
<br><br>
<div class="form-group row">
    <div class="col-sm-6 mb-3 mb-sm-0">
        <label for="title">Email Subject</label>
        <input type="text" class="form-control form-control-user" id="title" placeholder="Keep It Short">
    </div>
    <div class="col-sm-6">
        <label for="category">Email</label>
        <input type="email" class="form-control form-control-user" id="email" placeholder="Enter Email Address">
    </div>
</div>


<div class="form-group">
    <label for="author">Email Template</label>
    <select class="form-control form-control-user" id="template">
        <option value="1">Default Template</option>
        <option value="2">New Month Template</option>
        <option value="3">New Year Template</option>
        <option value="4">Celebration Template</option>
        <option value="5">New Article Template</option>
        <option value="6">Special Occasion Template</option>
    </select>
</div>


<div class="form-group">
    <label for="editor1">Email Body</label>
    <textarea class="form-control" id="editor1" placeholder="Let Your Thoughts Fly">
    </textarea>
</div>
<!--END OF SECTION ONE(1)-->
</div>
<!-- End of Main Content -->
<script>
CKEDITOR.replace('editor1');
</script>



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
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>S/N</th>
                        <th>Email</th>
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
                $pagination = $scripts->emailPagination($_SESSION['id'], $pageno);
                //echo $pagination;
                $pagination = explode("-", $pagination);
                $fLimit = $pagination[0];
                $lLimit = $pagination[1];
                $total_pages = $pagination[2];
                $gp = $scripts->getSubscribers($_SESSION['id'], $fLimit, $lLimit);
                if ($gp == true) {
                    $count = 1;
                    foreach ($gp as $row) {
                        ?>
                    <tr id='row<?php echo $row[' id']; ?>'>
                        <td><?php echo $count ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                            <button class=' btn btn-primary' id='p<?php echo $row[' id']; ?>'
                                onclick="inputE('<?php echo $row['email'];?>')">
                                Email
                            </button>
                        </td>
                    </tr>
                    <?php 
                    $count++; 
                    } 
                }
                 else {
                    echo "<div class='alert alert-info'>No Article Found</div>" ; 
                } 
                    ?>
                </tbody>
            </table>
            <ul class=" pagination justify-content-center my-4">
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
<!-- End of Main Content -->
<script>
function inputE(email) {
    $("#email").val(email);
    alert("Email loaded");
}
</script>
<?php include "templates/footer.html"; ?>