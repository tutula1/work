<h3>Test<sup>Working</sup></h3>
<center>    
<form action="?action=test" method="POST">
		
        <?php
if (isset($_POST['submit'])) {
    $mail = $_POST['mail'];
    $sql = "SELECT * FROM `candi` WHERE `mail` = '$mail'";
    $dtcadi = $data->ExcuteObjectList($sql);
    if (count($dtcadi) != 0) {
        echo "Email already exists";
    } else {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $job = $_POST['job'];
        $major = $_POST['major'];
        $link_card = $_POST['link_card'];
        $link_source = $_POST['link_source'];

        $sql = "INSERT INTO `card_candi`(`id`, `cadi`, `link_card`, `link_source`, 'status') VALUES (NULL, '$mail', '$link_card', '$link_source','0')";
        $data->ExcuteNonquery($sql);

        $sql = "INSERT INTO `candi`(`id`, `name`, `mail`, `phone`, `job`, `major`) VALUES (NULL, '$name', '$mail', '$phone', '$job', '$major')";
        $data->ExcuteNonquery($sql);
        $count = $_POST['count'];
        for ($i = 0; $i < $count; $i++) {
            $ques = $_POST['ques_'.$i];
            $anw = $_POST['anw_'.$i];
            $sql = "INSERT INTO `answer`(`id`, `question`, `answer`, `candi`) VALUES (NULL, '$ques', '$anw', '$mail')";
            $data->ExcuteNonquery($sql);
        }
        echo "Thank you for participating in tests";
    }
} else {
?>
			<iframe width="560" height="315" src="https://www.youtube.com/embed/kQqETH788MA" frameborder="0" allowfullscreen>
			</iframe>
			<h4>
				Making Card Guideline
			</h4>
			Click
			<a href="https://www.vingle.net/posts/new" target="_blank">here</a>
			to making card
			<hr />
			<h4>
				Card
			</h4>
			<table border="1" style="min-width: 400px;">
				<tr>
					<td>
						Link card:
					</td>
					<td>
						<input type="url" name="link_card" style="width: 100%;" required placeholder="https://www.vingle.net/..."/>
					</td>
				</tr>
				<tr>
					<td>
						Link source:
					</td>
					<td>
						<input type="url" name="link_source" style="width: 100%;" required/>
					</td>
				</tr>
			</table>
			<br />
			<hr />
			<h4>
				Infomation
			</h4>
			<table border="1" style="min-width: 400px;">
				<tr>
					<td>
						1. Name:
					</td>
					<td>
						<input type="text" name="name" style="width: 100%;" required/>
					</td>
				</tr>
				<tr>
					<td>
						2. Email:
					</td>
					<td>
						<input type="mail" name="mail" style="width: 100%;" required/>
					</td>
				</tr>
				<tr>
					<td>
						3. Phone:
					</td>
					<td>
						<input type="tel" name="phone" style="width: 100%;" required/>
					</td>
				</tr>
				<tr>
					<td>
						4. Current Job:
					</td>
					<td>
						<input type="text" name="job" style="width: 100%;" required/>
					</td>
				</tr>
				<tr>
					<td>
						5. Career / Major:
					</td>
					<td>
						<input type="text" name="major" style="width: 100%;" required/>
					</td>
				</tr>
			</table>
			<br />
            <hr />
			<h4>
				Question
			</h4>
			<table border="1" style="min-width: 800px">
                <?php
    $sql = "select * from question order by id asc";
    $dtques = $data->ExcuteObjectList($sql);
    $count = count($dtques);
    for ($i = 0; $i < $count; $i++) {
?>
				<tr>
					<td style="width: 30%;">
						<?php echo ($i + 1) . ". " . $dtques[$i]['question']; ?>
					</td>
					<td>
						<input type="text" name="anw_<?php echo $i ?>" style="width: 100%;" required/>
                        <input type="hidden" name="ques_<?php echo $i ?>" value="<?php echo
        $dtques[$i]['question'] ?>"/>
					</td>
				</tr>
                <?php
    }
?>
                <input type="hidden" name="count" value="<?php echo $count ?>" />
			</table>
			<br />
            <input type="submit" name="submit" value="Submit"/>
            </form>
            <?php
}
?>
		</center>