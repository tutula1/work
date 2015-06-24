<?php
@session_start();
include_once ("../database.php");
$data = new database();
include_once ("../function.php");
$payment = new Payment();
if (!isset($_SESSION['mail'])) {
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
<a href="index.php">Payment</a> 

<hr />
<h5>PAYMENT CALCULATION</h5>
Click <a target="_blank" href="/work/calculation.php">here</a>
<form action="" method="POST">
<h2>Time <input type="date" name="day_1" value="<?php if (isset($_POST['day_1'])) {
    echo $_POST['day_1'];
} else {
    echo date("Y-m-d", strtotime("-1 day"));
} ?>" max="<?php echo date("Y-m-d") ?>"/> => <input type="date" name="day_2" value="<?php if (isset($_POST['day_2'])) {
    echo $_POST['day_2'];
} else {
    echo date("Y-m-d");
} ?>" max="<?php echo date("Y-m-d") ?>"/> <input type="submit" /></h2>
</form>
	<table border="1" style="min-width: 600px;text-align: center;">
		<thead style="background-color: blue; color: #fff;">
			<tr>
				<th>
					Date
				</th>
				<th>
					Total
				</th>
				<th>
					Card
				</th>
                <th>
					Comment
				</th>
                <th>
					Source
				</th>
                <th>
					Post
				</th>
                <th>
					Pick
				</th>
                <th>
					Boost
				</th>
			</tr>
		</thead>
		<tbody>
        <?php
function diff_day($n1, $n2)
{
    $first_date = strtotime($n1);
    $second_date = strtotime($n2);
    $datediff = abs($first_date - $second_date);
    return floor($datediff / (60 * 60 * 24));
}
if (isset($_POST['pick'])) {
    $key = $_POST['key'];
    $sql = "update card set pro = '1' where key_card = '$key'";
    $data->ExcuteNonquery($sql);
}
if (!isset($_POST['day_1'])) {
    $day_1 = date("Y-m-d", strtotime("-1 day"));
    $day_2 = date("Y-m-d");
} else {
    $day_1 = $_POST['day_1'];
    $day_2 = $_POST['day_2'];
}
$diff_1 = diff_day($day_1, date("Y-m-d"));
$diff_2 = diff_day($day_1, $day_2);
$sum_total = 0;
$sum_card = 0;
$sum_comment = 0;
$sum_source = 0;
$sum_post = 0;
$sum_pick = 0;
$sum_boost = 0;
for ($i = 0; $i <= $diff_2; $i++, $diff_1--) {
    if ($diff_1 < 0) {
        break;
    }
    $date = date("Y-m-d", strtotime("-$diff_1 day"));
    $card = $payment->GetPaymentCardByDay($acc, $date);
    $comment = $payment->GetPaymentCommentByDay($acc, $date);
    $source = $payment->GetPaymentSourceByDay($acc, $date);
    $post = $payment->GetPaymentPostByDay($acc, $date);
    $pick = $payment->GetPaymentPickByDay($acc, $date);
    $boost = $payment->GetPaymentBoostByDay($acc, $date);
    $total = $card + $comment + $source + $post + $pick + $boost;

    $sum_total += $total;
    $sum_card += $card;
    $sum_comment += $comment;
    $sum_source += $source;
    $sum_post += $post;
    $sum_pick += $pick;
    $sum_boost += $boost;



?>
        <form action="" method="POST" onsubmit="return confirm('You want to pick?');">
        <input type="hidden" name="action" value="post" />
        <input type="hidden" name="key" value="<?php //echo $card['key_card'] ?>"  />
			<tr>
				<td>
					<?php echo $date ?>
				</td>
                <td>
					<?php echo number_format($total,0,".",",")." d"; ?>
				</td>
                <td>
					<?php echo number_format($card,0,".",",")." d"; ?>
				</td>
                <td>
					<?php echo number_format($comment,0,".",",")." d"; ?>
				</td>
                <td>
					<?php echo number_format($source,0,".",",")." d"; ?>
				</td>
                <td>
					<?php echo number_format($post,0,".",",")." d"; ?>
				</td>
                <td>
					<?php echo number_format($pick,0,".",",")." d"; ?>
				</td>
                <td>
					<?php echo number_format($boost,0,".",",")." d"; ?>
				</td>
                
				
			</tr>
            </form>
        <?php
}
?>
		</tbody>
        <tfoot style="background-color: red; color: #fff;">
			<tr>
				<th>
					Total Payment
				</th>
				<th>
					<?php echo number_format($sum_total,0,".",",")." d"; ?>
				</th>
				<th>
					<?php echo number_format($sum_card,0,".",",")." d";?>
				</th>
                <th>
					<?php echo number_format($sum_comment,0,".",",")." d"; ?>
				</th>
                <th>
					<?php echo number_format($sum_source,0,".",",")." d"; ?>
				</th>
                <th>
					<?php echo number_format($sum_post,0,".",",")." d"; ?>
				</th>
                <th>
					<?php echo number_format($sum_pick,0,".",",")." d"; ?>
				</th>
                <th>
					<?php echo number_format($sum_boost,0,".",",")." d"; ?>
				</th>
			</tr>
		</tfoot>
	</table>

</body>
</html>