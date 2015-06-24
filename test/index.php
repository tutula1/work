<?php
@session_start();
include_once ("../database.php");
$data = new database();
include_once("../function.php");
$payment = new Payment();
if(!isset($_SESSION['mail']))
{
    ?>
    <script>
    alert("You are not logged in");
    top.location = "/work";
    </script>
    <?php
    exit();
}
$acc = $_SESSION['mail'];
?>
<html>
<head></head>
<body>
<h3>Home > Test</h3>

<a href="../index.php">Home</a> &gt; 
<a href="index.php">Test</a> > 
<a href="?action=test">Test</a> |
<a href="?action=view">View</a> |
<a href="?action=edit">Edit</a>
<hr />
<?php
if(isset($_GET['action']))
include_once($_GET['action'].".php");
?>
</body>
</html>