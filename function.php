<?php
@session_start();
require_once "database.php";
/**
 * class payment
 */
class Payment
{
    var $db = null;

    /*privite function GetAccount()
    {
    $db = new database();
    $sql = "select * from account where mail_acc = '$mail'";
    $dtacc = $db->ExcuteObject($sql);
    return $dtacc;
    }*/
    /*privite function GetAccount()
    {
    $db = new database();
    $sql = "select * from account where mail_acc = '$mail'";
    $dtacc = $db->ExcuteObject($sql);
    return $dtacc;
    }*/
    function GetPaymentLang($lang)
    {
        $db = new database();
        $sql = "select * from price_source where short = '$lang'";
        $dtlang = $db->ExcuteObjectList($sql);
        return $dtlang[0]['price'];
    }
    function GetPaymentSourceById($id)
    {
        $db = new database();
        $sql = "select * from source where id_source = '$id'";
        $dts = $db->ExcuteObjectList($sql);
        return $this->GetPaymentLang($dts[0]['language']);

    }
    function GetPaymentSourceUser($user)
    {
        $db = new database();
        $sql = "select * from source where account = '$mail' and user != '' ";
        $dtsum = $db->ExcuteObjectList($sql);
        $sum = 0;
        $count = count($dtsum);
        for ($i = 0; $i < $sum; $i++) {
            $sum += $this->GetPaymentLang($dtsum[$i]['id']);
        }
        return $sum;
    }
    public function GetWord($str)
    {
        return str_word_count($str);
    }
    public function GetAmountImage($str)
    {
        return substr_count($str, "https://", 0);
    }
    public function GetPaymentPostByDay($acc, $day)
    {
        $db = new database();
        $sql = "SELECT * FROM `promotion` WHERE `user` = '$acc' and `date` like '$day%'";
        $dtpost = $db->ExcuteObjectList($sql);
        $count = count($dtpost);
        $sum = $this->GetPaymentPost() * $count;
        return $sum;
    }
    public function GetPaymentSourceByDay($acc, $day)
    {
        $db = new database();
        $sql = "SELECT * FROM `source` WHERE `account` = '$acc' and `date_select` like '$day%'";
        $dtpost = $db->ExcuteObjectList($sql);
        $count = count($dtpost);
        $sum = 0;
        for ($i = 0; $i < $count; $i++) {
            $id = $dtpost[$i]['id_source'];
            $sum += $this->GetPaymentSourceById($id);
        }
        return $sum;
    }

    public function GetPaymentPickByDay($acc, $day)
    {
        $db = new database();
        $sql = "SELECT * FROM `promotion` WHERE `pick` = '$acc' and `date_pick` like '$day%'";
        $dtpost = $db->ExcuteObjectList($sql);
        $count = count($dtpost);
        $sum = $this->GetPaymentPick() * $count;
        return $sum;
    }
    public function GetPaymentCardByDay($acc, $day)
    {
        $db = new database();
        $sum = 0;
        $sql = "select * from `user` where `acc_user` = '$acc'";
        $dtacc = $db->ExcuteObjectList($sql);
        for ($i = 0; $i < count($dtacc); $i++) {
            $user = $dtacc[$i]['name_user'];
            $sql = "SELECT * FROM `censor_card` WHERE `user` = '$user' and `create` like '$day%'";
            $dtpost = $db->ExcuteObjectList($sql);
            if (count($dtpost) > 0) {
                for ($j = 0; $j < count($dtpost); $j++) {
                    $id = $dtpost[$j]['key'];
                    $sum += $this->GetPaymentCardById($id);
                }
            }
        }
        return $sum;
    }
    public function GetPaymentCommentByDay($acc, $day)
    {
        $db = new database();
        $sum = 0;
        $sql = "select * from `user` where `acc_user` = '$acc'";
        $dtacc = $db->ExcuteObjectList($sql);
        for ($i = 0; $i < count($dtacc); $i++) {
            $user = $dtacc[$i]['name_user'];
            $sql = "SELECT * FROM `censor_comment` WHERE `user` = '$user' and `create` like '$day%'";
            $dtpost = $db->ExcuteObjectList($sql);
            if (count($dtpost) > 0) {
                for ($j = 0; $j < count($dtpost); $j++) {
                    $id = $dtpost[$j]['key'];
                    $sum += $this->GetPaymentCommentById($id);
                }
            }
        }
        return $sum;
    }
    public function GetPaymentBoostByDay($acc, $day)
    {
        $db = new database();
        $sql = "SELECT * FROM `promotion` WHERE `boost` = '$acc' and type = '3'  and `date_boost` like '$day%'";
        $dtpost = $db->ExcuteObjectList($sql);
        $count = count($dtpost);
        $sum = $this->GetPaymentBoost() * $count;
        return $sum;
    }
    public function GetPaymentPostByAcc($acc)
    {
        $db = new database();
        $sql = "select * from promotion where user='$acc'";
        $dtpost = $db->ExcuteObject($sql);
        $count = count($dtpost);
        $sum = 0;
        for ($i = 0; $i < $count; $i++) {
            $sum += $this->GetPaymentPost();
        }
        return $sum;
    }
    public function GetPaymentPost()
    {
        $db = new database();
        $sql = "select * from price_promotion where type='post'";
        $dtpost = $db->ExcuteObject($sql);
        return $dtpost['price'];
    }
    public function GetPaymentPickByAcc($acc)
    {
        $db = new database();
        $sql = "select * from promotion where pick='$acc'";
        $dtpost = $db->ExcuteObject($sql);
        $count = count($dtpost);
        $sum = 0;
        for ($i = 0; $i < $count; $i++) {
            $id = $dtpost[$i]['id_promotion'];
            $sum += $this->GetPaymentPick();
        }
        return $sum;
    }
    public function GetPaymentPick()
    {
        $db = new database();
        $sql = "select * from price_promotion where type='pick'";
        $dtpost = $db->ExcuteObject($sql);
        return $dtpost['price'];
    }
    public function GetPaymentBoostByAcc($acc)
    {
        $db = new database();
        $sql = "select * from promotion where boost='$acc'";
        $dtpost = $db->ExcuteObject($sql);
        $count = count($dtpost);
        $sum = 0;
        for ($i = 0; $i < $count; $i++) {
            $id = $dtpost[$i]['id_promotion'];
            $sum += $this->GetPaymentBoost();
        }
        return $sum;
    }
    public function GetPaymentBoost()
    {
        $db = new database();
        $sql = "select * from price_promotion where type='boost'";
        $dtpost = $db->ExcuteObject($sql);
        return $dtpost['price'];
    }
    public function GetPaymentImage($type)
    {
        $db = new database();
        $sql = "select * from price_image where id='$type'";
        $dtpost = $db->ExcuteObject($sql);
        return $dtpost['price'];
    }
    public function GetPaymentWorkLength($length)
    {
        $db = new database();
        $sql = "select * from price_word_length where min <= $length order by id desc limit 0,1";
        $dtpost = $db->ExcuteObjectList($sql);
        if (count($dtpost) > 0) {
            return $dtpost[0]['price'];
        } else {
            return 0;
        }
    }
    public function GetPaymentCommentLength($length)
    {
        $db = new database();
        $sql = "select * from price_comment where min <= $length  order by id desc limit 0,1";
        $dtpost = $db->ExcuteObjectList($sql);
        if (count($dtpost) > 0) {
            return $dtpost[0]['price'];
        } else {
            return 0;
        }
    }
    /*public function GetPaymentCommentLike($length)
    {
    $db = new database();
    $sql = "select * from price_live_comment where min <= $length  order by id desc limit 0,1";
    $dtpost = $db->ExcuteObjectList($sql);
    if(count($dtpost) > 0)
    {
    return $dtpost[0]['price'];
    }
    else
    {
    return 0;
    }
    }*/
    public function GetPaymentCountComment($count)
    {
        $db = new database();
        $sql = "select * from price_level_comment where min < $count  order by id desc limit 0,1";
        $dtpost = $db->ExcuteObjectList($sql);
        if (count($dtpost) > 0) {
            return $dtpost[0]['price'];
        } else {
            return 0;
        }
    }
    public function GetPaymentCommentLike($like)
    {
        $db = new database();
        $sql = "select * from price_like_comment where min <= $like  order by id desc limit 0,1";
        $dtpost = $db->ExcuteObjectList($sql);
        if (count($dtpost) > 0) {
            return $dtpost[0]['price'];
        } else {
            return 0;
        }
    }
    public function GetPaymentCPC($cpc)
    {
        $db = new database();
        $sql = "select * from price_cpc where min <= $cpc and max >= $cpc  order by id desc limit 0,1";
        $dtpost = $db->ExcuteObjectList($sql);
        if (count($dtpost) > 0) {
            return $dtpost[0]['price'];
        } else {
            return 0;
        }
    }
    public function GetPaymentCPR($cpr)
    {
        $db = new database();
        $sql = "select * from price_cpr where min <= $cpr and max >= $cpr  order by id desc limit 0,1";
        $dtpost = $db->ExcuteObjectList($sql);
        if (count($dtpost) > 0) {
            return $dtpost[0]['price'];
        } else {
            return 0;
        }
    }
    public function GetPaymentCTR($ctr)
    {
        $db = new database();
        $sql = "select * from price_ctr where min < $ctr  order by id desc limit 0,1";
        $dtpost = $db->ExcuteObjectList($sql);
        if (count($dtpost) > 0) {
            return $dtpost[0]['price'];
        } else {
            return 0;
        }
    }

    public function GetPaymentCardByType($type)
    {
        $db = new database();
        $sql = "select * from card_type where id = '$type'";
        $dtpost = $db->ExcuteObject($sql);
        return $dtpost['ratio'];
    }

    public function GetPaymentCardById($id)
    {
        $sum = 0;
        $db = new database();
        $sql = "SELECT * FROM `censor_card` WHERE `key` =  '$id'";
        $dtpost = $db->ExcuteObject($sql);
        $card_type = $dtpost['card_type'];
        if ($card_type == 0) {
            return 0;
        }

        $image_type = $dtpost['image_type'];
        if ($image_type == 0) {
            return 0;
        }
        $length = $this->GetWord($dtpost['content']);
        $sumlength = $this->GetPaymentWorkLength($length);
        $image = $this->GetAmountImage($dtpost['image']);
        if ($image > 10) {
            $image = 10;
        }
        $sumimage = $this->GetPaymentImage($image_type) * $image;
        $sum = ($sumimage + $sumlength) * $this->GetPaymentCardByType($card_type);
        $sum += $this->GetPaymentCardByComment($id);
        $sum += $this->GetPaymentCPCById($id);
        $sum += $this->GetPaymentCTRById($id);
        return $sum;
    }
    public function GetPaymentCardByComment($card)
    {
        $db = new database();
        $sql = "select count(*) as sum from censor_comment where card = '$card'";
        $dtpost = $db->ExcuteObject($sql);
        $sum = $dtpost['sum'];
        return $this->GetPaymentCountComment($sum);

    }
    public function GetPaymentCommentById($id)
    {
        $db = new database();
        $sql = "select * from `censor_comment` where `key` = '$id'";
        $dtpost = $db->ExcuteObject($sql);
        $sum = 0;
        $length = $this->GetWord($dtpost['content']);
        $sum += $this->GetPaymentCommentLength($length);
        $like = $dtpost['like'];
        $sum += $this->GetPaymentCommentLike($like);
        return $sum;

    }

    public function GetNameTypeImgage($type)
    {
        $db = new database();
        $sql = "SELECT * FROM `price_image` WHERE `id` =  '$type'";
        $dtpost = $db->ExcuteObject($sql);
        return $dtpost['type'];
    }
    public function GetNameTypeCard($type)
    {
        $db = new database();
        $sql = "SELECT * FROM `card_type` WHERE `id` =  '$type'";
        $dtpost = $db->ExcuteObject($sql);
        return $dtpost['des'];
    }
    public function GetPaymentCPCById($id)
    {
        $db = new database();
        $sql = "SELECT * FROM `promotion` WHERE `key` = '$id'";
        $dtpost = $db->ExcuteObjectList($sql);
        if (count($dtpost) == 0 || $dtpost[0]['type'] != 3) {
            return 0;
        }
        if ($dtpost[0]['click'] != 0) {
            $sum = $dtpost[0]['budget'] / $dtpost[0]['click'];
            return $sum;
        }
        return 0;


    }
    public function GetPaymentCPRById($id)
    {
        $db = new database();
        $sql = "SELECT * FROM `promotion` WHERE `key` = '$id'";
        $dtpost = $db->ExcuteObjectList($sql);
        if (count($dtpost) == 0 || $dtpost[0]['type'] != 3) {
            return 0;
        }
        if ($dtpost[0]['reach'] != 0) {
            $sum = $dtpost[0]['budget'] / $dtpost[0]['reach'];
            return $sum;
        }
        return 0;


    }
    public function GetPaymentCTRById($id)
    {
        $db = new database();
        $sql = "SELECT * FROM `promotion` WHERE `key` = '$id'";
        $dtpost = $db->ExcuteObjectList($sql);
        if (count($dtpost) == 0) {
            return 0;
        }
        if ($dtpost[0]['type'] != 3) {
            return 0;
        }
        if ($dtpost[0]['reach'] != 0) {
            $sum = floor($dtpost[0]['click'] * 100 / $dtpost[0]['reach']);
            return $this->GetPaymentCTR($sum);
        }
        return 0;


    }
}
