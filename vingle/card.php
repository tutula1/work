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
if (isset($_POST['insert'])) {

    $user = $_POST['user'];
    $content = $_POST['content'];
    $image = $_POST['image'];
    $lang = $_POST['lang'];

    /*$sql = "INSERT INTO `card`(`id_card`, `key_card`, `user_card`, `date_card`, `lang`, `source`, `content`, `image`, `view_card`, `like_card`, `clip`, `comment_card`, `type_card`, `payment`, `pro`) VALUES (NULL, '', '$user', now(), '$lang', '', '$content', '$image', '0','0','0','0','','0','0')";
    $data->ExcuteNonquery($sql);*/
}

$sql = "select * from user where acc_user = '$acc'";
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
					<a target="_blank" href="https://www.vingle.net/posts/<?php echo $card['key'] ?>"><?php echo $card['key'] ?></a>
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
            echo "<a href='".$dts[0]['link_source']."' target='_blank'>".substr($dts[0]['link_source'],0,15)."...</a>";
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
						  <?php
        $pm = 0;
        if ($card['image_type'] == 0) {
            //echo "Waiting";
        } else {
            $pm++;
            echo $payment->GetNameTypeImgage($card['image_type']);
        }

?>
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
					<?php if ($pm == 2) {
            echo $payment->GetPaymentCardById($card['key']);
        } ?>
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
    
    <hr />

<h5>Payment:</h5>
<p>....</p>
