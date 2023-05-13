<?php
require "config/db.php";
require "modals/all.php";

$database = new Database();
$db = $database->connect();
$run = new All($db);

//GET ALL USERS
$allUsers = $run->totalUsers();

//GET ALL ARTICLES
$allArticles = $run->totalArticles();


//GET ALL VIEWS
$allViews = $run->totalViews();


//GET ALL SUBSCRIBERS
$allSubscribers = $run->totalSubscribers();




$page = "Dashboard";
include "templates/header.php"; 
?>


                    <!-- Content Row -->
                    <div class="row">

                        <!-- Users Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Users</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $allUsers; ?></div>
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
                                                Articles </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $allArticles; ?></div>
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
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $allViews; ?></div>
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
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $allSubscribers; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-rocket fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

<!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Users</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Blog</th>
                                            <th>Email</th>
                                            <th colspan="3">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Blog</th>
                                            <th>Email</th>
                                            <th colspan="3">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $users = $run->getUsers();
                                        foreach($users as $user){
                                            $uid = $user['id'];
                                            $name = $user['fullname'];
                                            $userE = $user['email'];
                                            $blogN = $user['blogName'];
                                            $blogL = $user['blogLink'];
                                        ?>
                                        <tr>
                                            <td><?php echo $name; ?></td>
                                            <td><?php echo $blogN; ?></td>
                                            <td><?php echo $userE; ?></td>
                                            <td><a href="../posts/<?php echo $blogL; ?>" target="_blank"><button class="btn btn-primary">View</button></a></td>
                                            <td><button class="btn btn-dark">Block</button></td>
                                            <td><button class="btn btn-danger" id="d<?php echo $uid; ?>" onclick="deleteUser('<?php echo $uid; ?>')">Delete</button></td>
                                        </tr>
                                        <?php 
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

                    

            </div>
<script>
    function deleteUser(id) {
        $("#d"+id).attr("disabled", "true");
         $("#d"+id).html("Deleting <i class='fa fa-spinner fa-spin'></i>");
         var password = prompt("Enter Password To Delete User");
         $.ajax({
             type: "post",
             url: "controllers/delete.controller.php",
             data: {
                 delete: "",
                 password: password,
                 id: id
             },
             success: function(response){
                 if(response.includes("Successfully")){
                     $("#"+id).remove();
                     alert(response);
                 } else {
                     alert(response);
                 }
             }
         })
    }
</script>
            <!-- End of Main Content -->
  <?php include 'templates/footer.html'; ?>