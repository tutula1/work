<?php
if(isset($_REQUEST['insert']))
{
    $url = $_REQUEST['url'];
    $name = $_REQUEST['name'];
    $lang = $_REQUEST['language'];
    $time = $_REQUEST['time'];
    $sql = "INSERT INTO `source`(`id_source`, `name_source`, `account`, `link_source`, `date`, `language`) values (NULL, '$name', '$acc', '$url', '$time', '$lang')";
    $data->ExcuteNonquery($sql);
    
}
if(isset($_REQUEST['delete']))
{
    $id = $_REQUEST['delete'];
    $data->ExcuteNonquery("delete from source where id_source = '$id'");
}
if(isset($_REQUEST['key']))
{
    $url = $_REQUEST['url'];
    $name = $_REQUEST['name'];
    $lang = $_REQUEST['language'];
    $id = $_REQUEST['key'];
    $data->ExcuteNonquery("update source set link_source = '$url', name_source = '$name', language = '$lang' where id_source = '$id'");
}
?>


<div style="width: 100%;">
<h4>Add<sup>Working</sup></h4>
<form action="" method="POST">
<table border="1">
<tr>
<td>URL:</td>
<td><input type="url" name="url" required="true"/></td>
</tr>
<tr>
<td>Name:</td>
<td><input type="text" name="name" required="true" /></td>
</tr>
<tr>
<tr>
<td>Language:</td>
<td>
<select name="language">
<?php
$sql = "select * from price_source order by id asc";
$dtps = $data->ExcuteObjectList($sql);
for($i = 0; $i < count($dtps); $i++)
{
?>
<option value="<?php echo $dtps[$i]['short']?>"><?php echo $dtps[$i]['name']?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<td>Time</td>
<td><input type="text" name="time" value="<?php echo date("Y-m-d H:i:s");?>" readonly="true" /></td>
</tr>
<tr>
<td></td>
<td><input type="submit" name="insert" value="Insert"/> </td>
</tr>
</table>
</form>

</div>
<br />
<h4 class="page-header">
    My Source<sup>Working</sup>
    
</h4>
	<table class="table table-bordered table-hover" border="1" style="width: 800px;">
		<thead>
			<tr>
				<th>
					No.
				</th>
				<th>
					URL
				</th>
                <th>
                    Name
                </th>
				<th>
					Time
				</th>
				<th>
					Language
				</th>
                <th>
					Payment
				</th>
                <th>
					Edit
				</th>
			</tr>
		</thead>
		<tbody>
        <?php 
        $sql = "select * from source where account = '$acc'";
        $dtacc = $data->ExcuteObjectList($sql);
        $count_acc = count($dtacc);
        for($i = 0; $i < $count_acc; $i++)
        {
            $source = $dtacc[$i];
        ?>
			<tr>
				<td>
					<?php echo ($i+1)?>
				</td>
				<td>
					<a target="_blank" href="<?php echo $source['link_source']?>"><?php echo substr($source['link_source'],0,15)?>...</a>
				</td>
				<td>
					<?php echo $source['name_source']?>
				</td>
                <td>
					<?php echo $source['date']?>
				</td>
                <td>
					<?php 
                    $id_lang = $source['language'];
                    $sql = "select * from price_source where short = '$id_lang'";
                    $dtlang = $data->ExcuteObjectList($sql);
                    
                    echo $dtlang[0]['short']?>
				</td>
                <td>
					<?php echo number_format($payment->GetPaymentSourceById($source['id_source']),0,".",",")?>d
				</td>
				<td>
					<?php
					if($source['user'] == '')
					{
					?>
					<a href="?action=source&edit=<?php echo $source['id_source']?>" >Edit</a> / <a href="?action=source&delete=<?php echo $source['id_source']?>" onclick="return confirm('You want to delete?');">Delete</a>
					<?php
					}
					else
					{
						echo "Done";
					}
					?>
				</td>
			</tr>
        <?php
        }
        ?>
		</tbody>
	</table>

<br />
<?php
if(isset($_REQUEST['edit']))
{ 
    $id = $_REQUEST['edit'];
    $edit = $data->ExcuteObject("select * from source where id_source = '$id'");
?>
<form action="?action=source" method="POST">
<input type="hidden" value="<?php echo $id?>" name="key"/>
<h4>Edit<sup>Working</sup></h4>
<table border="1">
<tr>
<td>URL:</td>
<td><input type="url" name="url" required="true" value="<?php echo $edit['link_source']?>" /></td>
</tr>
<tr>
<td>Name:</td>
<td><input type="text" name="name" required="true" value="<?php echo $edit['name_source']?>" /></td>
</tr>
<tr>
<tr>
<td>Language:</td>
<td>
<select name="language">
<?php
$sql = "select * from price_source order by id asc";
$dtps = $data->ExcuteObjectList($sql);
for($i = 0; $i < count($dtps); $i++)
{
?>
<option value="<?php echo $dtps[$i]['short']?>" <?php if( $dtps[$i]['short'] == $edit['language']){ echo 'selected="true"';}?> ><?php echo $dtps[$i]['name']?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<td></td>
<td><input type="submit" name="pick" value="Update"/> </td>
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