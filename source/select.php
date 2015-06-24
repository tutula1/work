<h1 class="page-header">
    Source<sup>Working</sup>
    
</h1>

	<table class="table table-bordered table-hover" border="1" style="min-width: 600px;">
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
					User
				</th>
				<th>
					Time
				</th>
				
                <th>
					Select
				</th>
			</tr>
		</thead>
		<tbody>
        <?php
if (isset($_POST["key_select"])) {
    $id = $_POST["key_select"];
    $card = $_POST["card"];
    if ($card != "") {
        $data->ExcuteNonquery("update source set user = '$acc', card = '$card' where id_source = '$id'");
        //update card;
        //$data->ExcuteNonquery("update card set source = '$id' where id_card = '$card'");
    }
}
if (isset($_POST["key_edit"])) {
    $id = $_POST["key_edit"];
    $card = $_POST["card"];
    if ($card != "") {
        $data->ExcuteNonquery("update source set card = '$card' where id_source = '$id'");
        //update card;
        //$old = $_POST['old'];
        //$data->ExcuteNonquery("update card set source = '$id' where id_card = '$card'");
        //$data->ExcuteNonquery("update card set source = '' where id_card = '$old'");
    }
}


$sql = "select * from source where  user = ''";
$dtacc = $data->ExcuteObjectList($sql);
$count_acc = count($dtacc);
for ($i = 0; $i < $count_acc; $i++) {
    $source = $dtacc[$i];
?>
        
        <form action="?action=select" method="POST">
        <input type="hidden" name="id" value="<?php echo $source['id_source'] ?>" />
        <input type="hidden" name="url" value="<?php echo $source['link_source'] ?>" />
        <input type="hidden" name="name" value="<?php echo $source['name_source'] ?>" />
			<tr>
				<td>
					<?php echo ($i + 1) ?>
				</td>
				<td>
					<a target="_blank" href="<?php echo $source['link_source'] ?>"><?php echo substr($source['link_source'],0,15) ?>...</a>
				</td>
				<td>
					<?php echo $source['name_source'] ?>
				</td>
                <td>
					<?php echo $source['account'] ?>
				</td>
                <td>
					<?php echo $source['date'] ?>
				</td>
                <td>
					<input type="submit" name="select" value="Select" style="width: 100%;"/>
				</td>
				
			</tr>
        </form>
        <?php
}
?>
		</tbody>
	</table>
    <?php
if (isset($_POST['select'])) {

?>
    <form action="?action=select" method="POST">
    <input type="hidden" name="key_select" value="<?php echo $_POST['id'] ?>" />
<h4>Select<sup>Working</sup></h4>
<table border="1">
<tr>
<td>URL:</td>
<td><input type="url" readonly="true" value="<?php echo $_POST['url'] ?>" /></td>
</tr>
<tr>
<td>Name:</td>
<td><input type="text" readonly="true" value="<?php echo $_POST['name'] ?>"/></td>
</tr>
<tr>
<tr>
<td>Card ID:</td>
<td>
<input type="text" name="card" required="true" />
</td>
</tr>
<tr>
<td></td>
<td><input type="submit" value="Select"/> </td>
</tr>
</table>
</form>
<?php
}
?>
<br />
<h5>My Card by Source<sup>Working</sup></h5>
<table border="1" style="min-width: 600px;">
<tr>
<th>No.</th>
<th>Card ID</th>
<th>Source</th>
<th>Time</th>
<th>Edit</th>
</tr>
<?php
$sql = "select * from source where  user = '$acc'";
$dtacc = $data->ExcuteObjectList($sql);
$count_acc = count($dtacc);
for ($i = 0; $i < $count_acc; $i++) {
    $source = $dtacc[$i];
    ?>
    <form action="" method="POST">
    <input type="hidden" name="id" value="<?php echo $source['id_source']?>" />
    <input type="hidden" name="card" value="<?php echo $source['card']?>" />
    <input type="hidden" name="name" value="<?php echo $source['name_source']?>" />
    <tr>
    <td><?php echo ($i+1)?></td>
    <td>
    <a target="_blank" href="https://www.vingle.net/posts/<?php echo $source['card'] ?>"><?php echo $source['card'] ?></a>
    </td>
    <td><?php echo $source['id_source']?></td>
    <td><?php echo $source['date']?></td>
    <td><input type="submit" name="edit" value="Edit" style="width: 100%;"/></td>
    </tr>
    </form>
<?php
}
?>
</table>
<br />
<?php
if (isset($_POST['edit'])) {

?>
<h5>Edit<sup>Working</sup></h5>
<form action="?action=select" method="POST">
<input type="hidden" name="key_edit" value="<?php echo $_POST['id']?>"/>
<input type="hidden" name="old" value="<?php echo $_POST['card']?>"/>
<table border="1">
<tr>
<td>Card ID:</td>
<td><input type="text" name="card"  value="<?php echo $_POST['card']?>"   /></td>
</tr>
<tr>
<td>Source:</td>
<td><input type="text" name="id" readonly="true" value="<?php echo $_POST['id']?>"/></td>
</tr>

<tr>
<td></td>
<td><input type="submit" name="pick" value="Update"/> </td>
</tr>
</table>


</form>
<?php
}
?>
<br />