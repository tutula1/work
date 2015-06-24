<h4>
    Account<sup>Working</sup>
    
</h4>
<div style="width: 100%;">
<a href="?action=account&add=account">&nbsp;Add Account</a>

</div>
<br />
	<table  border="1" style="min-width: 600px;">
		<thead>
			<tr>
				<th>
					No
				</th>
				<th>
					Account
				</th>
				<th>
					Time
				</th>
                <th>
					Note
				</th>
				<th>
					
				</th>
			</tr>
		</thead>
		<tbody>
        <?php 
        $alert = "";
        if(isset($_GET['delete']))
        {
            $id = $_GET['delete'];
            $sql = "delete from user where id_user = '$id'";
            $data->ExcuteNonquery($sql);
            $alert = "Delete success";
        }
        if(isset($_GET['key']))
        {
            $id = $_GET['key'];
            $name = $_GET['name'];
            $note = $_GET['note'];
            $sql = "select * from user where name_user = '$name' and id_user != '$id'";
            $dtu = $data->ExcuteObjectList($sql);
            if(count($dtu) > 0)
            {
                $alert = "Name already exists";
            }
            else {
                $alert = "Update success";
            $sql = "update user set name_user = '$name', note = '$note' where id_user = '$id'";
            $data->ExcuteNonquery($sql);
            }
        }
        if(isset($_GET['insert']))
        {
            $name = $_GET['name'];
            $note = $_GET['note'];
            $sql = "select * from user where name_user = '$name'";
            $dtu = $data->ExcuteObjectList($sql);
            if(count($dtu) > 0)
            {
                $alert = "Name already exists";
            }
            else {
                $alert = "Insert success";
            $sql = "insert into user values (NULL, '$acc', '$name', now(), '$note')";
            $data->ExcuteNonquery($sql);
            }
        }
        $sql = "select * from user where acc_user = '$acc'";
        $dtacc = $data->ExcuteObjectList($sql);
        $count_acc = count($dtacc);
        for($i = 0; $i < $count_acc; $i++)
        {
            $user = $dtacc[$i];
        ?>
			<tr>
				<td>
					<?php echo ($i+1)?>
				</td>
				<td>
					<?php echo $user['name_user']?>
				</td>
				<td>
					<?php echo $user['date']?>
				</td>
                <td>
					<?php echo $user['note']?>
				</td>
				<td>
					<a href="?action=account&edit=<?php echo $user['id_user']?>">Edit</a> / <a href="javascript:void()" onclick="delete_acc('<?php echo $user['id_user']?>')">Delete</a>
				</td>
			</tr>
        <?php
        }
        ?>
		</tbody>
	</table>
</div>
<br />
<?php
echo $alert;
if(isset($_GET['edit']))
{
    $id = $_GET['edit'];
    $sql = "select * from user where id_user = '$id'";
    $dtuser = $data->ExcuteObjectList($sql);
?>
<h4>Edit<sup>Working</sup></h4>
<form action="" method="GET">
<input type="hidden" name="action" value="account" />
<input type="hidden" name="key" value="<?php echo $id?>" />
<table border="1">
<tr>
<td>Account:</td>
<td><input name="name" value="<?php echo $dtuser[0]['name_user'];?>" required="true"  /></td>
</tr>
<tr>
<td>Note:</td>
<td><input name="note" value="<?php echo $dtuser[0]['note'];?>"  /></td>
</tr>
</table>


<input type="submit" name="submit" value="Update" />
<?php
}

if(isset($_GET['add']))
{
?>
<h4>Add<sup>Working</sup></h4>
<form action="" method="GET">
<input type="hidden" name="action" value="account" />
<table border="1">
<tr>
<td>Account:</td>
<td><input name="name" value="" required="true"  /></td>
</tr>
<tr>
<td>Note:</td>
<td><input name="note" value=""  /></td>
</tr>
</table>
<input type="submit" name="insert" value="Insert" />
<?php
}
?>
<script>
function delete_acc(n)
{
  result = confirm('You want to delete?');  
  if(result == true)
  {
    top.location="?action=account&delete="+n;
  }
}
</script>