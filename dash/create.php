<?php 
$page = "New Article";
$id = "new";
include "templates/header.php"; ?>
<script>
$("#<?php echo $id ?>").attr("class", "nav-item active");
</script>

<!--START OF SECTION ONE(1)-->
<script src="editor/ckeditor1/ckeditor.js"></script>
<center>
    <div class="form-group row">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <button class="btn btn-success" type="submit" id="publish">Save and Publish</button>
        </div>
        <div class="col-sm-6">
            <button class="btn btn-dark" type="submit" id="sad">Save as Draft</button>
        </div>
    </div>
</center>


<div class="form-group row">
    <div class="col-sm-6 mb-3 mb-sm-0">
        <label for="title">Title</label>
        <input type="text" class="form-control form-control-user" id="title" placeholder="Try Some Facinating Title">
    </div>
    <div class="col-sm-6">
        <label for="category">Category</label>
        <input type="text" class="form-control form-control-user" id="category"
            placeholder="What Category is your article Under">
    </div>
</div>


<div class="form-group">
    <label for="author">Author</label>
    <input type="text" class="form-control form-control-user" id="author"
        placeholder="Let Your Viewers Know Who Wrote The Article">
</div>


<div class="form-group">
    <label for="editor1">Article Content</label>
    <textarea class="form-control" id="editor1" placeholder="Let Your Thoughts Fly">
    </textarea>
</div>
<!--END OF SRCTION ONE(1)-->
</div>
<!-- End of Main Content -->
<script>
CKEDITOR.replace('editor1');
</script>
<script>
//If Published is Clicked
$("#publish").click(function() {
    //DISABLE INPUTS AND BUTTONS
    $(".form-group input").attr("disabled");
    $("#sad").attr("disabled");
    $("#publish").attr("disabled");
    $("#editor1").attr("disabled");
    $("#publish").html("Publishing <i class='fa fa-spinner fa-spin'></i>");

    //GET ALL INPUT VALUES
    var title = $("#title").val();
    var category = $("#category").val();
    var author = $("#author").val();
    var body = CKEDITOR.instances['editor1'].getData();

    $.ajax({
        type: "POST",
        url: "controllers/create.controller.php",
        data: {
            create_p: '',
            status: 'published',
            title: title,
            category: category,
            author: author,
            body: body
        },
        success: function(data) {
            $(".form-group input").removeAttr("disabled");
            $("#sad").removeAttr("disabled");
            $("#publish").removeAttr("disabled");
            $("#exampleFormControlTextarea1").removeAttr("disabled");
            $("#title").val("");
            $("#category").val("");
            $("#author").val("");
            $("#editor1").val("");
            $("#publish").html("Save and Publish");
            swal("Post Created", data, "success") // show response from the php script.
            //alert(data);
        }
    });

});


// If Draft is Clicked
$("#sad").click(function() {
    //DISABLE INPUTS AND BUTTONS
    $(".form-group input").attr("disabled");
    $("#sad").attr("disabled");
    $("#publish").attr("disabled");
    $("#sad").html("Saving as draft <i class='fa fa-spinner fa-spin'></i>");

    //GET ALL INPUT VALUES
    var title = $("#title").val();
    var category = $("#category").val();
    var author = $("#author").val();
    editor = CKEDITOR.instances.content;
    var body = CKEDITOR.instances['editor1'].getData();

    $.ajax({
        type: "POST",
        url: "controllers/create.controller.php",
        data: {
            create_p: '',
            status: 'draft',
            title: title,
            category: category,
            author: author,
            body: body
        },
        success: function(data) {
            $(".form-group input").removeAttr("disabled");
            $("#sad").removeAttr("disabled");
            $("#publish").removeAttr("disabled");
            $("#exampleFormControlTextarea1").removeAttr("disabled");
            $("#title").val("");
            $("#category").val("");
            $("#author").val("");
            $("#editor1").val("");
            $("#publish").html("Save and Publish");
            swal("Post Created", data, "success") // show response from the php script.
            //alert(data);
        }
    });

});
</script>
<?php include "templates/footer.html"; ?>