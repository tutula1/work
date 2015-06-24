<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
class database
{
    var $connect = '';
    var $array = array();
    function database()
    {

        //$this->Connected("localhost", "bongorg_bet", "bongorg_root", "leminhtam123");
        //$this->Connected("db07.serverhosting.vn", "von55795_bong", "von55795", "leminhtam123");
        $this->Connected("localhost", "automation_system", "root", "");

    }
    //b7_14992510 user
    //pass same
    //sql103.byethost7.com
    //b7_14992510_ql_hinhanh
    public function Connected($hostname, $database, $id, $pass)
    {
        //echo $hostname;
        $this->connect = mysql_connect($hostname, $id, $pass);
        //if(!mysql_connect($hostname,$id,$pass))
        // {
        //    die('None Connection '.mysql_error());
        // }
        if (!mysql_select_db($database, $this->connect)) {
            die('Wrong DB ' . mysql_error());
        }

    }
    function Query($sql)
    {
        mysql_query('SET NAMES UTF8', $this->connect);
        $this->array = mysql_query($sql, $this->connect);
        return $this->array;
    }

    function ExcuteObject($sql)
    {

        $data = $this->Query($sql);
        if ($row = mysql_fetch_array($data)) {

            $kq = $row;
        }
        return $kq;
    }
    function ExcuteObjectList($sql)
    {

        $data = $this->Query($sql);
        $ret = array();
        while ($row = mysql_fetch_array($data)) {
            $ret[] = $row;
        }
        return $ret;
    }
    function ExcuteNonquery($sql)
    {
        mysql_query('SET NAMES UTF8', $this->connect);
        mysql_query($sql, $this->connect);
        //echo mysql_error();
    }

}


?>