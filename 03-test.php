<?php
require 'core.php';

$errArray = array();

if (isset($_POST['submit'])) {
  if ($tmp = uploadFile($errArray, $_FILES['file'])) {
    var_dump(getFileUrl($tmp));
    echo "<a href='".getFileUrl($tmp)."' target='_blank'>IMAGE ICI :D</a>";
    var_dump($errArray);
  } else {
    var_dump($errArray);
  }
}

var_dump(removeFile($errArray, 'fu81k4lD5eAbv3n17cVd36Nm4aq04Xf7CR5o8d0P2pric.png'));
?>
<form method="post" action="" enctype="multipart/form-data">
  <input type="file" name="file">
  <input type="submit" name="submit">
</form>
