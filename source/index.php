<?php
@session_start();
include_once ("../database.php");
$data = new database();
include_once("../function.php");
$payment = new Payment();
//echo $payment->GetPaymentWorkLength(20);
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
<a href="index.php">Source</a> > 
<a href="?action=source">My source</a> |
<a href="?action=select">Select source</a>
<hr />
<h5>PAYMENT CALCULATION</h5>
Click <a target="_blank" href="/work/calculation.php">here</a>
<?php
if(isset($_GET['action']))
include_once($_GET['action'].".php");
?>
</body>
</html>