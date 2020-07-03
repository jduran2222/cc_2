<?php
//ini_set("session.use_trans_sid",true);
session_start();
session_unset();
session_destroy();
?>

<?php
header('Location: index.php');
?>
