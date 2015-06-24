<?php
@session_start();
include_once ("database.php");
$data = new database();
if (!isset($_SESSION['mail'])) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>

    <script type="text/javascript">
alert("You are not logged in");
    top.location = "/work";
    </script><?php
    exit();
}
?>

    <title>TEST</title>
    <style type="text/css">
div.c4 {text-align: center}
    table.c3 {min-width: 800px}
    td.c2 {text-align: center;}
    td.c1 {width: 30%;}
    </style>
</head>

<body>
    <h3>Test<sup>Working</sup></h3>

    <div class="c4">
        <form action="" method="post">
            <?php
if (isset($_POST['submit'])) {
    $count_an = 0;
    $count = $_POST['count'];
    for ($i = 0; $i < $count; $i++) {
        $anw = $_POST['ques_' . $i];
        $an = $_POST['an_' . $i];
        //  echo $anw." - ". $an."<br>";
        if ($an == $anw) {
            $count_an++;
        }
        //$data->ExcuteNonquery($sql);
    }
    if ($count_an*100/$count > 70) {
        $sql =  "update `account` set test = '1' where `mail_acc` = '".$_SESSION['mail']."'";
        $data->ExcuteNonquery($sql);
        echo "Thank you for participating in tests";
?>
            <br>
            Click <a href="./">here</a> 
            <?php
    } else {
        echo "Your answer: $count_an/$count. Please try again";
?>
            <br>
            <a href="test.php">Test again</a> <?php
    }

} else {
    
?>
<button onclick="top.location = './'">OK</button> 
<iframe width="560" height="315" src="https://www.youtube.com/embed/kQqETH788MA" frameborder="0" allowfullscreen=""></iframe>

            <h4>Making Card Guideline</h4>

            <h4>Question</h4><input type="hidden" name="count" value="<?php echo
$count ?>">

            <table border="1" class="c3">
                <?php
    $sql = "select * from question_test order by id asc";
    $dtques = $data->ExcuteObjectList($sql);
    $count = count($dtques);
    for ($i = 0; $i < $count; $i++) {
?>

                <tr>
                    <td class="c1"><?php echo ($i + 1) . ". " . $dtques[$i]['question']; ?></td>

                    <td class="c2"><input type="hidden" name="an_<?php echo $i ?>" value="<?php echo
$dtques[$i]['answer'] ?>" required="true"> <input type="radio" name="ques_<?php echo $i ?>" value="1"><?php echo
        $dtques[$i]['an_1'] ?> <input type="radio" name="ques_<?php echo $i ?>" value="2" required="true"><?php echo
            $dtques[$i]['an_2'] ?> <input type="radio" name="ques_<?php echo $i ?>" value="3" required="true"><?php echo
            $dtques[$i]['an_3'] ?> <input type="radio" name="ques_<?php echo $i ?>" value="" required="true"><?php echo
            $dtques[$i]['an_4'] ?></td>
                </tr><?php
    }
?>
            </table>
            <br>
            <input type="hidden" name="count" value="<?php echo $count ?>"> <input type="submit" name="submit" value="Submit">
        </form><?php
}
?>
    </div>
</body>
</html>
