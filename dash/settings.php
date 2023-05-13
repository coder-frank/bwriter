<?php 
require_once 'config/db.php';
require_once 'models/function.php';

$db = new Database();
$db = $db->connect();
$scripts = new scripts($db);

$page = "Settings";
$id = "dash";
include "templates/header.php"; ?>
<script>
$("#<?php echo $id ?>").attr("class", "nav-item active");
</script>

<!--START of section one(1)-->

<center>
    <section class="bg-white" style="border-radius: 19px;">
        <div class="container">
            <br>
            <h2 class="form-title">Manage your Fonts And Size</h2>
            <br>
            <p id="demo-text">Demo Text</p>
            <br>
            <?php
            $fontS = $scripts->getFont($_SESSION['id'], "fontS");
            $fontF = $scripts->getFont($_SESSION['id'], "fontF");
            if (!$fontS == false) {
            foreach ($fontS as $size) {
            $fontS = $size['reply'];
            }
            } else {
            $fontS = "16";
            }

            if (!$fontF == false) {
            foreach ($fontF as $fam) {
            $fontF = $fam['reply'];
            }
            } else {
            $fontF = "serif";
            }
            ?>
            <div class="form-group">
                <label for="size">Choose Font Size</label>
                <input class="form-control form-control-user" type="number" id="size" placeholder="Font Size"
                    value="<?php echo $fontS; ?>" />
            </div>
            <div class=" form-group">
                <label for="font">Choose Font</label>
                <select class="form-control form-control-user" id="font" placeholder="Font">
                    <?php
                            echo $fontF.$fontS;
                                   $fvalues = array(
                                        "serif", 
                                        "sans-serif", 
                                        "'Courier New', Courier, monospace",
                                        "'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif", 
                                        "'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif", 
                                        "'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif", 
                                        "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif", 
                                        "'Times New Roman', Times, serif", 
                                        "Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif", 
                                        "Arial, Helvetica, sans-serif", 
                                        "Georgia, 'Times New Roman', Times, serif", 
                                        "Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif", 
                                        "Verdana, Geneva, Tahoma, sans-serif", 
                                        "cursive", 
                                        "fantasy", 
                                        "monospace"
                                    );
                                   $fDisplay = array(
                                        "Serif", 
                                        "Sans-serif", 
                                        "Courier New", 
                                        "Franklin", 
                                        "Gill Sans MT", 
                                        "Lucida Sans", 
                                        "Segoe UI", 
                                        "Times New Roman", 
                                        "Trebuchet MS", 
                                        "Arial", 
                                        "Geogia", 
                                        "Impact", 
                                        "Verdana", 
                                        "Cursive", 
                                        "Fantasy", 
                                        "Monospace"
                                    );

                                   for ($i=0; $i < count($fvalues); $i++) {
                                    if ($fvalues[$i] == $fontF) {
                                        echo '<option selected style="-webkit-appearance:none;background:#123f6b; color:white;" value="'.$fvalues[$i].'">'.$fDisplay[$i].'</option>';
                                    } else {
                                        echo '<option style="-webkit-appearance:none;background:#123f6b; color:white;" value="'.$fvalues[$i].'">'.$fDisplay[$i].'</option>';
                                    }
                                    
                                   }

                                ?>
                </select>
            </div>


            <div class="form-group">
                <input type="submit" id="save" class="form-submit btn btn-primary" value="Save Setting" />
            </div>
            <br>
        </div>
    </section>
</center>

<!--END OF SECTION ONE(1)-->

<!--START OF SECTION TWO()-->
<br><br>
<center>
    <section class="bg-white" style="border-radius: 19px;">
        <div class="container">
            <br>
            <h2 class="form-title">Change Your Password</h2>
            <br>
            <div class="form-group">
                <label for="old">Old Password</label>
                <input type="password" class="form-control form-control-user" id="oldP"
                    placeholder="Enter Your Old Password">
            </div>

            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="newP">New Password</label>
                    <input type="password" class="form-control form-control-user" id="newP"
                        placeholder="Enter New Secure Password">
                </div>
                <div class="col-sm-6">
                    <label for="category">Repeat Password</label>
                    <input type="password" class="form-control form-control-user" id="newR"
                        placeholder="Repeat The Password Just To Be Sure">
                </div>
            </div>
            <br>
            <div class="form-group">
                <input type="submit" id="change" class="form-submit btn btn-primary" value="Change Password" />
            </div>
            <br>
        </div>
    </section>
</center>



<!--END OF SECTION TWO()-->




<!-- End of Main Content -->

<!--SCRIPT FOR FONTS -->
<script>
setInterval(function() {
    var fsize = $("#size").val();
    var fontF = $("#font").val();
    var t = 1;
    $("#demo-text").css("font-size", fsize + "px");
    $("#demo-text").css({
        "font-family": fontF
    });
    if (t == 1) {
        t++;
    }

}, 500);
</script>


<!--CHANGE FONT-->
<script>
$("#save").click(function() {
    $("#save").html("Saving setting<i class='fa fa-spinner fa-spin'></i>");
    var inputs = ["fontS", "fontF", "save"];
    for (let i = 0; i < inputs.length; i++) {
        $("#" + inputs[i]).attr("disabled", "disabled");
    };
    var fsize = $("#size").val();
    var fontF = $("#font").val();

    $.ajax({
        type: "post",
        url: "controllers/font.controller.php",
        data: {
            font: '',
            fontS: fsize,
            fontF: fontF
        },
        success: function(response) {
            for (let i = 0; i < inputs.length; i++) {
                $("#" + inputs[i]).removeAttr("disabled");
            }
            $("#save").html("Save Setting");
            if (response.includes("Successful")) {
                swal("Password Change", response, "success");
            } else {
                swal("Opps!", response, "error");
            }
        }
    });
})
</script>


<script>
$("#change").click(function() {
    $("#change").html("Authenticating <i class='fa fa-spinner fa-spin'></i>");
    var inputs = ["oldP", "newP", "newR"];
    for (let i = 0; i < inputs.length; i++) {
        $("#" + inputs[i]).attr("disabled", "disabled");
    };
    var old = $("#oldP").val();
    var pwd = $("#newP").val();
    var cpwd = $("#newR").val();
    if (old.length < 1 || pwd.length < 1 || cpwd.length < 1) {
        for (let i = 0; i < inputs.length; i++) {
            $("#" + inputs[i]).removeAttr("disabled");
        }
        swal("Opps!", "All the fields are required", "error");
        //alert("Opps!", "All the fields are required", "error");
        $("#change").html("Change Password");
    } else if (cpwd != pwd) {
        for (let i = 0; i < inputs.length; i++) {
            $("#" + inputs[i]).removeAttr("disabled");
        }
        swal("Opps!", "Passwords do not match", "error");
        $("#change").html("Change Password");
    } else {
        $.ajax({
            type: "post",
            url: "controllers/changePassword.controller.php",
            data: {
                change: '',
                old: old,
                new: pwd
            },
            success: function(result) {
                for (let i = 0; i < inputs.length; i++) {
                    $("#" + inputs[i]).removeAttr("disabled");
                }
                $("#change").html("Change Password");
                if (result.includes("Successful")) {
                    swal("Password Change", result, "success");
                    //alert(result)
                } else {
                    swal("Opps!", result, "error");
                    //alert(result)
                }
            }
        });

    }


})
</script>
<?php include "templates/footer.html"; ?>