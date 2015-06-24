<h4 class="page-header">
    Post<sup>Working</sup>
    
</h4>

	<table border="1" style="min-width: 600px;">
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
					Post
				</th>
			</tr>
		</thead>
		<tbody>
        <?php 
        if(isset($_POST['update']))
        {
            $id = $_POST['id'];
            $url = $_POST['url'];
            $sql = "update promotion set link_promotion = '$url' where id_promotion = '$id'";
            $data->ExcuteNonquery($sql);
        }
        if(isset($_POST['pick']))
        {
            $key = $_POST['id'];
            $url = $_POST['link'];
            $time = $_POST['time'];
            $data->ExcuteNonquery("INSERT INTO `promotion`(`id_promotion`, `link_promotion`, `date`, `type`, `key`, `user`) VALUES (NULL, '$url', '$time', '0', '$key', '$acc')");
        }
        
        
        $sql = "Select * FROM censor_card as a WHEre NOT EXISTS(Select * FROM promotion as b WHERE a.key = b.key)";
        $dtcard = $data->ExcuteObjectList($sql);
        $count_card = count($dtcard);
        for($j = 0; $j < $count_card; $j++)
        {
            $card = $dtcard[$j];
        ?>
        <form action="" method="POST">
        <input type="hidden" name="action" value="post" />
        <input type="hidden" name="key" value="<?php echo $card['key']?>"  />
			<tr>
				<td>
					<?php echo ($j+1);?>
				</td>
                <td>
					<a target="_blank" href="https://www.vingle.net/posts/<?php echo $card['key'] ?>"><?php echo $card['key'] ?></a>
				</td>
                <td>
					<?php echo $card['user']?>
				</td>
                <td>
					<?php echo $card['create']?>
				</td>
                <td>
					<input type="submit" name="post" value="Post" style="width: 100%;" />
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
if(isset($_POST['post']))
{
?>
<form action="?action=post" method="POST">
<table border="1">
<tr>
<td>Card ID:</td>
<td><input type="text" name="id" readonly="true" value="<?php echo $_POST['key']?>" /></td>
</tr>
<tr>
<td>FB Link:</td>
<td><input type="url" name="link" required="true"/></td>
</tr>
<tr>
<td>Post Time</td>
<td><input type="text" name="time" value="<?php echo date("Y-m-d H:i:s");?>" readonly="true" /></td>
</tr>
<tr>
<td></td>
<td><input type="submit" name="pick" value="Post"/> </td>
</tr>
</table>


</form>
<?php
}
?>
<br />
<h5>My Post List<sup>Working</sup></h5>
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
$sql = "select * from promotion where user = '$acc'";
$dtcard = $data->ExcuteObjectList($sql);
$count_card = count($dtcard);
for($j = 0; $j < $count_card; $j++)
{
    $post = $dtcard[$j];
?>
<form action="?action=post" method="POST">
<input type="hidden" name="id" value="<?php echo $post['id_promotion']?>" />
<input type="hidden" name="url" value="<?php echo $post['link_promotion']?>" />
<tr>
<td><?php echo ($j+1)?></td>
<td><?php echo $post['key']?></td>
<td><a target="_blank" href="<?php echo $post['link_promotion']?>"><?php echo substr($post['link_promotion'],0,15)?>...</a></td>
<td><?php echo $post['date']?></td>
<td><?php echo number_format($payment->GetPaymentPost(),0,".",",")." d"?></td>
<td><input type="submit" name="edit" value="Edit" style="width: 100%;"/></td>
</tr>
</form>
<?php
}
?>
</table>
<br />
<?php
if(isset($_POST['edit']))
{
?>
<h5>Edit<sup>Working</sup></h5>
<form action="?action=post" method="POST">
<table border="1">
<tr>
<td>Card ID:</td>
<td><input type="text" name="id" readonly="true" value="<?php echo $_POST['id']?>"/></td>
</tr>
<tr>
<td>FB Link:</td>
<td><input type="text" name="url" value="<?php echo $_POST['url']?>" /></td>
</tr>

<tr>
<td></td>
<td><input type="submit" name="update" value="Update"/> </td>
</tr>
</table>


</form>
<br />
<?php
}
?>
<hr />

<h5>Payment:</h5>
<p>....</p>
