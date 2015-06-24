<h4 class="page-header">
    Boost<sup>Working</sup>
    
</h4>

	<table border="1" style="min-width: 800px;">
		<thead>
			<tr>
				<th>
					No.
				</th>
                <th>
					User
				</th>
                <th>
					Card
				</th>
				<th>
					Fb Link
				</th>
				<th>
					Start time
				</th>
                <th>
					End time
				</th>
                <th>
					Budget
				</th>
                <th>
					CPR
				</th>
                <th>
					CPC
				</th>
                <th>
					CTR
				</th>
                <th>
					Status
				</th>
                <th>
					Update
				</th>
			</tr>
		</thead>
		<tbody>
        <?php
if (isset($_POST['up'])) {
    $key = $_POST['key'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    $budget = $_POST['budget'];
    $reach = $_POST['reach'];
    $click = $_POST['click'];
    $date = $_POST['date'];
    $add = "";
    $type = $_POST['type'];
    if ($date == "1") {
        $add = ", date_boost = now()";
    }
    $cpc = "0";
    $cpr = "0";
    $ctr = "0";
    if ($type == 3) {
        if ($budget != 0) {
            if ($reach != 0 && $click != 0) {
                $cpc = round(number_format($budget / $click, 2));
                $cpr = round(number_format($budget / $reach, 2));
                $ctr = round(number_format($click / $reach, 2),2);
            } else {
                $cpc = "0";
                $cpr = "0";
                $ctr = "0";
                if ($reach != 0) {
                    $cpr = round(number_format($budget / $reach, 2));
                }
                if ($click != 0) {
                    $cpc = round(number_format($budget / $click, 2));
                }
            }
        }
    }
    $sql = "update promotion set start = '$start', end='$end', budget='$budget', reach='$reach', click='$click', type = '$type', boost='$acc', cpc = '$cpc', cpr = '$cpr', ctr = '$ctr'  " .
        $add . " where id_promotion = '$key'";
    //echo $sql;
    $data->ExcuteNonquery($sql);
}
$sql = "select * from promotion where type > 0";
$dtcard = $data->ExcuteObjectList($sql);
$count_card = count($dtcard);
for ($j = 0; $j < $count_card; $j++) {
    $boost = $dtcard[$j];
?>
        <form action="" method="POST">
        <input type="hidden" name="action" value="post" />
        <input type="hidden" name="key" value="<?php echo $boost['id_promotion'] ?>"  />
			<tr>
				<td>
					<?php echo ($j + 1) ?>
				</td>
                <td>
					<?php echo $boost['pick'] ?>
				</td>
                <td>
					<a target="_blank" href="https://www.vingle.net/posts/<?php echo $boost['key'] ?>"><?php echo $boost['key'] ?></a>
				</td>
                <td>
					<a target="_blank" href="<?php echo $boost['link_promotion'] ?>"><?php echo
substr($boost['link_promotion'], 0, 15) ?>...</a>
				</td>
                <td>
					<?php echo $boost['start'] ?>
					<input type="hidden" name="start" value="<?php echo $boost['start'] ?>">
				</td>
                <td>
					<?php echo $boost['end'] ?>
					<input type="hidden" name="end" value="<?php echo $boost['end'] ?>">
				</td>
                <td>
					<?php echo number_format($boost['budget'],0,".",",")." d" ?>    
					<input type="hidden" name="budget" value="<?php  echo $boost['budget']?>">
				</td>
                <td>
					<?php echo number_format($boost['cpr'],0)." d" ?>

				</td>
                <td>
					<?php echo number_format($boost['cpc'],0)." d" ?>
				</td>
                <td>
					<?php echo number_format($boost['ctr'],2)."%" ?>
				</td>   
                <td>
					<?php if ($boost['type'] == 1) {
        echo "Pending";
    } else
        if ($boost['type'] == 2) {
            echo "Boosted";
        } else {
            echo "Finished";
        } ?>
					<input type="hidden" name="type" value="<?php echo $boost['type'] ?>">
				</td>
                <td>
					<input type="submit" name="update" value="Update" style="width:100%" />
					<input type="hidden" name="click" value="<?php echo $boost['click'] ?>">
					<input type="hidden" name="reach" value="<?php echo $boost['reach'] ?>">
				</td>
                
                
				
			</tr>
            </form>
        <?php
}

?>
		</tbody>
	</table>
<br />
<?php
if (isset($_POST['update'])) {

?>

<h4>Update<sup>Working</sup></h4>
<form action="?action=boost" method="POST">
<input type="hidden" name="key" value="<?php echo $_POST['key'] ?>">
<input type="hidden" name="date" value="<?php if ($_POST['type'] == 1) {
        echo "1";
    } else {
        echo "0";
    } ?>">
<table border="1">
<tr>
<td>Start time:</td>
<td><input type="date" name="start" value="<?php echo $_POST['start'] ?>"  required <?php if ($_POST['type'] !=
1) {
        echo "readonly";
    } ?>/>
</td>
<td>End time:</td>
<td><input type="date" name="end" value="<?php echo $_POST['end'] ?>"   min="<?php echo
date('Y-m-d') ?>"/>
</td>
</tr>
<tr>
<td>Status</td>
<td>
<select name="type">
<option value="1" <?php if ($_POST['type'] == 1) {
        echo "selected='true'";
    }
    ;
    /*if ($_POST['type'] > 1) {
        echo "disabled='true'";
    }*/ ?> >Pending</option>
<option value="2" <?php if ($_POST['type'] == 2) {
        echo "selected='true'";
    }
    /*if ($_POST['type'] > 2) {
        echo "disabled='true'";
    }*/ ?>>Boost</option>
<option value="3" <?php if ($_POST['type'] == 3) {
        echo "selected='true'";
    } ?>>Finished</option>
</select></td>


</tr>	
<tr>
<td>Budget</td>
<td><input type="tel" name="budget" value="<?php echo $_POST['budget'] ?>" /></td>
<td>Paid Reach</td>
<td><input type="tel" name="reach" value="<?php echo $_POST['reach'] ?>"  /></td>
<td>Paid Click</td>
<td><input type="tel" name="click" value="<?php echo $_POST['click'] ?>" /></td>
</tr>
</table>
<input type="submit" name="up" value="Update"/>
</form>
<br />
<?php
}


?>
<hr />

<h5>Payment:</h5>
<p>....</p>

