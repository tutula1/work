<?php
@session_start();
include_once ("database.php");
$data = new database();
if(isset($_SESSION['mail']))
{
    $sql =  "select * from `account` where `mail_acc` = '".$_SESSION['mail']."' and `test` = '1'";
    $dttest = $data->ExcuteObjectList($sql);
    if(count($dttest) == 0 )
    {
        ?>
        <script>
            top.location = "test.php";
        </script>
        <?php
        exit();
    }
}
function isValidEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
if (isset($_POST['logout'])) {
    if (isset($_SESSION['name'])) {
        session_unset();
        echo "you have logged out";
    } else {
        echo "You are not logged in";
    }
}
if (isset($_POST['forgot'])) {
    $mail = $_POST['mail_fo'];
    if (isValidEmail($mail) == false) {
        echo "Email is malformed";
    }
    $sql = "select * from account where mail_acc = '$mail'";
    $dtacc = $data->ExcuteObject($sql);
    if (count($dtacc) > 0) {
        echo "your password: " . $dtacc['pwd_acc'];
    } else {
        echo "Email does not exist";
    }
}
if (isset($_POST['signin'])) {
    if (isset($_SESSION['name'])) {
        echo "you are logged";
    } else {
        $mail = $_POST['mail_in'];
        if (isValidEmail($mail) == false) {
            echo "Email is malformed";
        } else {
            $pass = $_POST['pwd_in'];
            $sql = "select * from account where mail_acc = '$mail' and pwd_acc = '$pass'";
            $dtacc = $data->ExcuteObjectList($sql);
            if (count($dtacc) > 0) {
                echo "login success!!!";
                $_SESSION['name'] = $dtacc[0]['name_acc'];
                $_SESSION['mail'] = $mail;
                if($dtacc[0]['test'] == 0)
                {
                ?>
                <script>
                    top.location = "test.php";
                </script>
                <?php
                }
            } else {
                echo "login failed";
            }
        }
    }

}
if (isset($_POST['update'])) {
    $name = $_POST['name_update'];
    $pass = $_POST['pwd_update'];
    $mail = $_POST['mail_update'];
    if (strlen($mail) != 0 && isValidEmail($mail) == false) {
        echo "Email is malformed";
    } else {
        if (!isset($_SESSION['mail'])) {
            echo "You are not logged in";
        } else {
            $sql = "select * from account where mail_acc = '$mail'";
            $dtacc = $data->ExcuteObjectList($sql);
            if (count($dtacc) > 0 && strlen($mail) > 0) {
                echo "Email already exists";
            } else {
                $update = 0;
                $str = "update account set id_acc = id_acc ";
                if (strlen($pass) < 4 && strlen($pass) > 0) {
                    echo "Passwords must be more than 4 characters";
                } else
                    if (strlen($pass) > 4) {
                        $update = 1;
                        $str .= ", pwd_acc = '$pass'";
                    }
                if (strlen($name) != 0) {
                    $update = 1;
                    $str .= ", name_acc = '$name'";
                    $_SESSION['name'] = $name;
                }
                if (strlen($mail) != 0) {
                    $update = 1;
                    $str .= ", mail_acc = '$mail'";
                    $_SESSION['mail'];
                }
                $mail_cur = $_SESSION['mail'];
                if ($update == 1) {
                    $str .= " where mail_acc = '$mail_cur'";
                    $data->ExcuteNonquery($str);
                    echo "update success!!!";
                }
            }

        }
    }
}
if (isset($_POST['signup'])) {
    $name = $_POST['name_up'];
    $pass = $_POST['pwd_up'];
    $mail = $_POST['mail_up'];
    if (isValidEmail($mail) == false) {
        echo "Email is malformed";
        return;
    } else {
        $cpass = $_POST['cpwd_up'];
        if (isset($_SESSION['mail'])) {
            echo "you are logged";
        } else {
            if ($pass != $cpass) {
                echo "Confirm password do not match";
            } else {
                $sql = "select * from account where mail_acc = '$mail'";
                $dtacc = $data->ExcuteObjectList($sql);
                if (count($dtacc) > 0) {
                    echo "Email already exists";
                } else {
                    if (strlen($pass) > 4) {
                        $sql = "insert into account values (NULL, '$name', '$mail', '$pass', now())";
                        $data->ExcuteNonquery($sql);
                        $_SESSION['name'] = $name;
                        $_SESSION['mail'] = $mail;
                    } else {
                        echo "Passwords must be more than 4 characters";
                    }
                }
            }
        }
    }
}
?>
<html>
<head></head>
<body>
<h3>Home</h3>
<?php
if (isset($_SESSION['mail'])) {
?>
<a href="index.php">Home</a> &gt; 
<a href="test">Test</a> |
<a href="vingle">Vingle</a> |
<a href="source">Source</a> |
<a href="promotion">Promotion</a> |
<a href="payment">Payment</a>
<hr />
<?php
}
if (!isset($_SESSION['name'])) {
    echo "You are not logged in";
} else {
    echo "Hello, " . $_SESSION['name'];
}
?>

<hr />
<h2>Sign in<sup>Working</sup></h2>
<form action="" method="POST">
<table>
<tr>
<td></td>
<td></td>
</tr>
<tr>
<td>Mail:</td>
<td><input type="email" name="mail_in" required="true" />*</td>
</tr>
<tr>
<td></td>
<td></td>
</tr>
<tr>
<td>Password:</td>
<td><input type="password" name="pwd_in" required="true"/>*</td>
</tr>
</table>
<input type="submit" name="signin"/>
</form>

<hr />
<h2>Sign up<sup>Working</sup></h2>
<form action="" method="POST">
<table>
<tr>
<td>Name:</td>
<td><input type="text" name="name_up"required="true" />*</td>
<td></td>
</tr>
<tr>
<td>Mail:</td>
<td><input type="email" name="mail_up" required="true" />*</td>
<td></td>
</tr>
<tr>
<td>Password:</td>
<td><input type="password" name="pwd_up" required="true"/>*</td>
<td></td>
</tr>
<tr>
<td>Confirm Password:</td>
<td><input type="password" name="cpwd_up" required="true"/>*</td>
<td></td>
</tr>
</table>
<input type="submit" name="signup"/>
</form>
<hr />
<h2>Logout<sup>Working</sup></h2>
<form action="" method="POST">
<input value="Logout" type="submit" name="logout"/>
</form>
<hr />

<h2>Update<sup>Working</sup></h2>
(blank if not updated)
<form action="" method="POST">
<table>
<tr>
<td>Name:</td>
<td><input type="text" name="name_update" /></td>
<td></td>
</tr>
<tr>
<td>Mail:</td>
<td><input type="text" name="mail_update"  /></td>
<td></td>
</tr>
<tr>
<td>Password:</td>
<td><input type="text" name="pwd_update" /></td>
<td></td>
</tr>
</table>
<input type="submit" name="update"/>
</form>
<hr />
<h2>Forgot Password<sup>Working</sup></h2>
<form action="" method="POST">
<label for="mail_fo">Mail</label>
<input type="email" name="mail_fo"  required="true"/>
<input value="Send" type="submit" name="forgot"/>
</form>
<hr />
<h2>List account<sup>Working</sup></h2>
<table border="1">
<tr>
<td>No</td>
<td>Name</td>
<td>Mail</td>
<td>Password</td>
<td>Date Create</td>
</tr>
<?php
$sql = "select * from account";
$dtacc = $data->ExcuteObjectList($sql);
$count = count($dtacc);
for ($i = 0; $i < $count; $i++) {
    echo "<tr>";
    echo "<td>" . ($i + 1) . "</td>";
    echo "<td>" . $dtacc[$i]['name_acc'] . "</td>";
    echo "<td>" . $dtacc[$i]['mail_acc'] . "</td>";
    echo "<td>" . substr($dtacc[$i]['pwd_acc'], 0, strlen($dtacc[$i]['pwd_acc']) -3) . "***</td>";
    echo "<td>" . $dtacc[$i]['date'] . "</td>";
    echo "</tr>";
}
?>
</table>

</body>
</html>