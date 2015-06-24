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
<h3>Home > Vingle</h3>

<a href="../index.php">Home</a> &gt; 
<a href="index.php">Vingle</a> > 
<a href="?action=account">Account</a> |
<a href="?action=card">Card</a> |
<a href="?action=comment">Comment</a>
<hr />
<h5>PAYMENT CALCULATION</h5>
Click <a target="_blank" href="/work/calculation.php">here</a>
<?php
if(isset($_GET['action']))
include_once($_GET['action'].".php");
?>
</body>
</html>