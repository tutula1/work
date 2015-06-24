<h4 class="page-header">
    Card List
    <sup>Working</sup>
</h4>

	<table border="1" style="min-width: 600px;">
		<thead>
			<tr>
				<th>
					Card ID
				</th>
                <th>
					Account
				</th>
				<th>
					Time
				</th>
                <th>
					Source
				</th>
                <th>
					Content(Word)
				</th>
                <th>
					Image(Amount)
				</th>
				<th>
					Image Type
				</th>
                <th>
					Card Type
				</th>
                <th>
					Comment
				</th>
                <th>
					Payment
				</th>
			</tr>
		</thead>
		<tbody>
        <?php
$sql = "select * from user";
$dtacc = $data->ExcuteObjectList($sql);
$count_acc = count($dtacc);
for ($i = 0; $i < $count_acc; $i++) {
    $user = $dtacc[$i];
    $name = $user['name_user'];
    $sql = "select * from censor_card where user = '$name'";
    $dtcard = $data->ExcuteObjectList($sql);
    $count_card = count($dtcard);
    for ($j = 0; $j < $count_card; $j++) {
        $card = $dtcard[$j];
?>
			<tr>
                <td>
					<?php echo $card['key'] ?>
				</td>
                <td>
					<?php echo $name ?>
				</td>
                <td>
					<?php echo $card['create'] ?>
				</td>
                <td>
					<?php
        $key = $card['key'];
        $sql = "select * from source where card = '$key'";
        $dts = $data->ExcuteObjectList($sql);
        if (count($dts)) {
            echo $dts[0]['id_source'];
        }
?>
				</td>
                <td>
					<?php echo $payment->GetWord($card['content']) ?>
				</td>
                <td>
					<?php echo $payment->GetAmountImage($card['image']) ?>
				</td>
                <td>
						  <select name="image_type">
        <?php
$sql = "select * from user where acc_user = '$acc'";
$dtacc = $data->ExcuteObjectList($sql);
$count_acc = count($dtacc);
for ($i = 0; $i < $count_acc; $i++) {
    $user = $dtacc[$i];
    $name = $user['name_user'];
?>
        <option value="<?php echo $name ?>">
        <?php echo $name ?>
        </option>
        <?php
}
?>
        </select>
				</td>
                <td>
						  <?php if ($card['image_type'] == 0) {
            //echo "Waiting";
        } else {
            $pm++;
            echo $payment->GetNameTypeCard($card['card_type']);
        }

?>
				</td>
                <td>
						<?php
        $id = $card['key'];
        $sql = "select count(*) as sum from censor_comment where card = '$id'";
        $dtcom = $data->ExcuteObject($sql);
        //$dtcom['sum'] = rand(0,30);
        echo $dtcom['sum'];

?>
				</td>
				<td>
					<input type="submit" name="update" value="Update" />
				</td>
				
			</tr>
        <?php
    }
}
?>
		</tbody>
	</table>   
    
    
    <hr />
    
    <form action="?action=card" method="POST">
    <h4>Add</h4>
    <!--<table border="1" style="min-width: 800px;">
    <thead>
			<tr>
                <th>
					Account
				</th>
                <th>
					Language
				</th>
                <th style="min-width:600px;">
					Content
				</th>
                <th>
					Image(Amount)
				</th>
			</tr>
		</thead>
        <tbody>
        <tr>
        <td>
        <select name="user">
        <?php
$sql = "select * from user where acc_user = '$acc'";
$dtacc = $data->ExcuteObjectList($sql);
$count_acc = count($dtacc);
for ($i = 0; $i < $count_acc; $i++) {
    $user = $dtacc[$i];
    $name = $user['name_user'];
?>
        <option value="<?php echo $name ?>">
        <?php echo $name ?>
        </option>
        <?php
}
?>
        </select>
        </td>
        <td>
        <select name="lang">
<?php

$sql = "select * from price_source order by id asc";
$dtps = $data->ExcuteObjectList($sql);
for ($i = 0; $i < count($dtps); $i++) {
?>
<option value="<?php echo $dtps[$i]['id'] ?>" ><?php echo $dtps[$i]['name'] ?></option>
<?php
}
?>
</select>
        </td>
        <td >
        <textarea name="content"  rows="8" style="width: 100%;" required="true" maxlength="5000"></textarea>
        </td>
        <td>
        <input type="tel" name="image" value="0" required="true" />
        </td>
        </tr>
        </tbody>
    </table>
    <input type="submit" name="insert" value="Insert"/>-->
    </form>
    <a target="_blank" href="/work/restful.php">RESTFUL</a>