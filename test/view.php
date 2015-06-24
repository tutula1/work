<h3>
View
</h3>
<table border="1" style="min-width: 800px;">
<thead>
<th>No.</th>
<th>Mail</th>
<th>Link Card</th>
<th>Link Source</th>
<th>Status</th>
<th></th>
</thead>
<tbody>
<?php
if (isset($_POST['update'])) {
    $sql = "update card_candi set status = '" . $_POST['status'] . "' where id = '" .
        $_POST['id'] . "'";
    //echo $sql;
    $data->ExcuteNonquery($sql);
}

$sql = "SELECT * FROM `card_candi`";
$dtcadi = $data->ExcuteObjectList($sql);
$count = count($dtcadi);
for ($i = 0; $i < $count; $i++) {
?>
<form action="?action=view" method="POST">
<td><?php echo ($i + 1) ?></td>
<td><?php echo $dtcadi[$i]['cadi'] ?></td>
<td><a href="<?php echo $dtcadi[$i]['link_card'] ?>" target="_blank"><?php echo
    substr($dtcadi[$i]['link_card'], 0, 30) ?>...</a></td>
<td><a href="<?php echo $dtcadi[$i]['link_source'] ?>" target="_blank"><?php echo
        substr($dtcadi[$i]['link_source'], 0, 20) ?>...</a></td>
<td>
<select name="status">
<option value="0" <?php if ($dtcadi[$i]['status'] == 0)
        echo " selected='true'" ?>>Waiting</option>
<option value="1" <?php if ($dtcadi[$i]['status'] == 1)
            echo " selected='true'" ?>>Checked</option>

</select>
</td>
<td>
<input type="hidden" name="id" value="<?php echo $dtcadi[$i]['id'] ?>" />
<input type="submit" name="view" value="View" style="width: 50%;" />
<input type="submit" name="update" value="Update" style="width: 50%;" />
</td>
</tr>
</form>
<tr>
<?php
}
?>
</tbody>
</table>
<hr />
<?php
if (isset($_POST['view'])) {
    $sql = "select * from candi where id = '" . $_POST['id'] . "'";
    $dtcadi = $data->ExcuteObject($sql);
?>
<h4>Detail</h4>
<table border="1" style="min-width: 800px;">
<thead>
<th>Name</th>
<th>Mail</th>
<th>Phone</th>
<th>Current Job</th>
<th>Career / Major</th>
</thead>
<tbody>
<tr>
<td><?php echo $dtcadi['name'] ?></td>
<td><?php echo $dtcadi['mail'] ?></td>
<td><?php echo $dtcadi['phone'] ?></td>
<td><?php echo $dtcadi['job'] ?></td>
<td><?php echo $dtcadi['major'] ?></td>
</tr>
</tbody>
</table>
<br />
 <table border="1" style="min-width: 800px">
 <?php
    $sql = "select * from answer where candi = '" . $dtcadi['mail'] .
        "' order by question asc";
    $dtq = $data->ExcuteObjectList($sql);
    for ($i = 0; $i < count($dtq); $i++) {
?>
<tr>
<td style="width: 35%;">
<b>
<?php
echo $dtq[$i]['question'];  
?>
</b>
</td>
<td>
<?php
        echo $dtq[$i]['answer'];
?>
</td>
</tr>
 <?php
    }
?>
 </table>

<?php
}
?>