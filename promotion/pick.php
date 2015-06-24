<h4 class="page-header">
    Pick<sup>Working</sup>
    
</h4>

	<table border="1" style="min-width: 600px;">
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
					Time
				</th>
                <th>
					Pick
				</th>
			</tr>
		</thead>
		<tbody>
        <?php 
        if(isset($_POST['pick']))
        {
            $key = $_POST['key'];
            $sql = "update promotion set type = '1' , pick = '$acc', date_pick = now() where id_promotion = '$key'";
            $data->ExcuteNonquery($sql);
        }
         if(isset($_POST['remove']))
        {
            $key = $_POST['id'];
            $sql = "update promotion set type = '0' , pick = '', date_pick='' where id_promotion = '$key'";
            $data->ExcuteNonquery($sql);
        }
        
        
        $sql = "select * from promotion where type = '0'";
        $dtcard = $data->ExcuteObjectList($sql);
        $count_card = count($dtcard);
        for($j = 0; $j < $count_card; $j++)
        {
            $pick = $dtcard[$j];
        ?>
        <form action="" method="POST" onsubmit="">
        <input type="hidden" name="action" value="post" />
        <input type="hidden" name="key" value="<?php echo $pick['id_promotion']?>"  />
			<tr>
				<td>
					<?php echo ($j+1)?>
				</td>
                <td>
					<?php echo $pick['user'] ?>
				</td>
                <td>
					<a target="_blank" href="https://www.vingle.net/posts/<?php echo $pick['key'] ?>"><?php echo $pick['key'] ?></a>
				</td>
                <td>
					<a target="_blank" href="<?php echo $pick['link_promotion']?>"><?php echo substr($pick['link_promotion'],0,15)?>...</a>
				</td>
                <td>
					<?php echo $pick['date']?>
				</td>
                <td>
					<input type="submit" name="pick" value="Pick" style="width: 100%;" />
				</td>
                
				
			</tr>
            </form>
        <?php
        }
        
        ?>
		</tbody>
	</table>



<h5>My Pick List<sup>Working</sup></h5>
<table border="1" style="min-width: 600px;">
<tr>
<th>No.</th>
<th>Card ID</th>
<th>FB Link</th>
<th>Time</th>
<th>Payment</th>
<th>Edit</th>
</tr>
<?php 
$sql = "select * from promotion where pick = '$acc' and type = '1'";
$dtcard = $data->ExcuteObjectList($sql);
$count_card = count($dtcard);
for($j = 0; $j < $count_card; $j++)
{
    $post = $dtcard[$j];
?>
<form action="?action=pick" method="POST">
<input type="hidden" name="id" value="<?php echo $post['id_promotion']?>" />
<tr>
<td><?php echo ($j+1)?></td>
<td><?php echo $post['key']?></td>
<td><a target="_blank" href="<?php echo $post['link_promotion']?>"><?php echo substr($post['link_promotion'],0,15)?>...</a></td>
<td><?php echo $post['date']?></td>
<td><?php echo number_format($payment->GetPaymentPick(),0,".",",")." d"?></td>
<td><input type="submit" name="remove" value="Remove" style="width: 100%;"/></td>
</tr>
</form>
<?php
}
?>
</table>
<br />

<hr />

<h5>Payment:</h5>
<p>....</p>