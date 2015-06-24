<h4 class="page-header">
    Comment<sup>Working</sup>
    
</h4>

	<table border="1" style="min-width: 800px;">
		<thead>
			<tr>
				<th>
					No.
				</th>
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
					Content(Work)
				</th>
                <th>
					Like
				</th>
                <th>
					Payment
				</th>
			</tr>
		</thead>
		<tbody>
        <?php
$sql = "select * from user where acc_user = '$acc'";
$dtacc = $data->ExcuteObjectList($sql);
$count_acc = count($dtacc);
for ($i = 0; $i < $count_acc; $i++) {
    $user = $dtacc[$i];
    $name = $user['name_user'];
    $sql = "select * from censor_comment where user = '$name'";
    $dtcard = $data->ExcuteObjectList($sql);
    $count_card = count($dtcard);
    for ($j = 0; $j < $count_card; $j++) {
        $com = $dtcard[$j];
?>
			<tr>
				<td>
					<?php echo ($j + 1) ?>
				</td>
                <td>
					<a target="_blank" href="https://www.vingle.net/posts/<?php echo $com['key'] ?>"><?php echo $com['key'] ?></a>
				</td>
                <td>
					<?php echo $com['user'] ?>
				</td>
                <td>
					<?php echo $com['create'] ?>
				</td>
                <td>
					<?php
        $length = $payment->GetWord($com['content']);
        echo $length ?>
				</td>
                
				<td>
					<?php echo $com['like'] ?>
				</td>
                <td>
				<?php echo number_format($payment->GetPaymentCommentById($com['key']),0,".",",")." d" ?>
				</td>
			</tr>
        <?php
    }
}
?>
		</tbody>
	</table>





<hr />

<h5>Payment:</h5>
Click <a target="_blank" href="/work/calcutation.php">here</a>