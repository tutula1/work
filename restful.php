<?php

set_time_limit(1200);

include 'database.php';
$DB = new database();

/*$file = @fopen('log/' . date('Y-m-d') . '.censor.log', 'a');
if (!@$file)
    $file = @fopen('C:/xampp/htdocs/vingle/a/log/' . date('Y-m-d') . '.censor.log',
        'a');
if (!@$file)
    $file = @fopen('D:/xampp/htdocs/vgl.vn/vingle/a/log/' . date('Y-m-d') .
        '.censor.log', 'a');
*/
function record($log)
{
    //global $file;
    //fwrite($file, $log);
    echo $log;
}

record("\r\n\r\n\r\n" . date('Y-m-d H:i:s') . ' censor.process.php' . "\r\n");


////
///
//  Configuration

$F = @$argv[1] ? $argv[1] : date('Y-m-d H:i:s', strtotime('-426 minutes'));
$T = @$argv[2] ? $argv[2] : date('Y-m-d H:i:s', strtotime('-420 minutes'));
$N = @$argv[3] ? $argv[3] : date('Y-m-d H:i:s', strtotime('-420 minutes'));

// The time zone of Ha Noi is GMT+7.
// Even thoug the cron cycle is 5 minutes, the crawling cycle is 6 minutes to prevent data loss.
record( $F . "\r\n" . $T . "\r\n" . $N . "\r\n" ); // To debug...

$attribute = array('http' => array('method' => "GET", 'header' =>
            "X-Vingle-Application-Id: 6dfce2b7ad47686969dcad79f5c35955\r\n" .
            "X-Vingle-Rest-Api-Token: 1fc9343b9ce0262a36b16f526933183c\r\n"));

$context = stream_context_create($attribute);


////
///
//  Crawl Card

record("\r\n" . date('Y-m-d H:i:s') . ' CRAWL card' . "\r\n");

// record( 'http://api1.vingle.net/api/censor/card?from=' . urlencode( $F ) . '&to=' . urlencode( $T ) ); // To debug...

// $data = json_decode( file_get_contents( 'http://api1.vingle.net/api/censor/card?from=' . urlencode( $F )
//                                                                               . '&to=' . urlencode( $T ), false, $context ), true );

// I couldn't know the reason, but function file_get_contents( ) lose the result from function stream_context_create( ).

$cURL = curl_init();

curl_setopt_array($cURL, array(

    CURLOPT_URL => "http://api1.vingle.net/api/censor/card?from=" . urlencode($F) .
        "&to=" . urlencode($T),

    CURLOPT_HTTPHEADER => array(
        "X-Vingle-Application-Id: 6dfce2b7ad47686969dcad79f5c35955",
        "X-Vingle-Rest-Api-Token: 1fc9343b9ce0262a36b16f526933183c",
        "Content-Type:            application/json",
        "Accept:                  application/json"),

    CURLOPT_RETURNTRANSFER => 1));

$data = json_decode(curl_exec($cURL), true);

foreach (@$data as $V) {

    $RS = $DB->query('SELECT `key` FROM `censor_card` WHERE `key` = "' . $V['id'] .
        '"');

    if (!@$RS->num_rows) {

        $DB->query('INSERT INTO `censor_card` ( `key`     ,
                                                 `user`    ,
                                                 `IP`      ,
                                                 `language`,
                                                 `interest`,
                                                 `title`   ,
                                                 `content` ,
                                                 `image`   ,
                                                 `create`  ,
                                                 `publish` ,
                                                 `insert`  )
                                        VALUES ( "' . @$V['id'] . '",
                                                 "' . @$V['username'] . '",
                                                 "' . @$V['ip_address'] . '",
                                                 "' . @$V['language_code'] . '",
                                                 "' . @$V['communities'] . '",
                                                 "' . str_replace('"', '\\"', @
            $V['title']) . '",
                                                 "' . str_replace('"', '\\"', @
            $V['content']) . '",
                                                 "' . @$V['images'] . '",
                                                 "' . @$V['created_at'] . '",
                                                 "' . @$V['publish_at'] . '",
                                                 NOW( ) )');

    } else {

        $DB->query('UPDATE `censor_card` SET `user`     = "' . @$V['username'] . '",
                                              `IP`       = "' . @$V['ip_address'] .
            '",
                                              `language` = "' . @$V['language_code'] .
            '",
                                              `interest` = "' . @$V['communities'] .
            '",
                                              `title`    = "' . str_replace('"',
            '\\"', @$V['title']) . '",
                                              `content`  = "' . str_replace('"',
            '\\"', @$V['content']) . '",
                                              `image`    = "' . @$V['images'] .
            '",
                                              `create`   = "' . @$V['created_at'] .
            '",
                                              `publish`  = "' . @$V['publish_at'] .
            '",
                                              `update`   = NOW( )
                                        WHERE `key`      = "' . @$V['id'] . '"');

    }

    record(date('Y-m-d H:i:s') . ' ' . (!@$RS->num_rows ? 'INSERT' : 'UPDATE') .
        ' card ' . @$V['id'] . "\r\n");

} // foreach


////
///
//  Crawl Comment

record("\r\n" . date('Y-m-d H:i:s') . ' CRAWL comment' . "\r\n");

curl_setopt_array($cURL, array(

    CURLOPT_URL => "http://api1.vingle.net/api/censor/comment?from=" . urlencode($F) .
        "&to=" . urlencode($T),

    CURLOPT_HTTPHEADER => array(
        "X-Vingle-Application-Id: 6dfce2b7ad47686969dcad79f5c35955",
        "X-Vingle-Rest-Api-Token: 1fc9343b9ce0262a36b16f526933183c",
        "Content-Type:            application/json",
        "Accept:                  application/json"),

    CURLOPT_RETURNTRANSFER => 1));

$data = json_decode(curl_exec($cURL), true);

foreach (@$data as $V) {

    $RS = $DB->query('SELECT `key` FROM `censor_comment` WHERE `key` = "' . $V['id'] .
        '"');

    if (!@$RS->num_rows) {

        $DB->query('INSERT INTO `censor_comment` ( `key`     ,
                                                    `card`    ,
                                                    `user`    ,
                                                    `IP`      ,
                                                    `language`,
                                                    `interest`,
                                                    `content` ,
                                                    `create`  ,
                                                    `publish` ,
                                                    `insert`  )
                                           VALUES ( "' . @$V['id'] . '",
                                                    "' . (intval(@$V['post_id']) ?
            @$V['post_id'] : @$V['card_id']) . '",
                                                    "' . @$V['username'] . '",
                                                    "' . @$V['ip_address'] . '",
                                                    "' . @$V['language_code'] .
            '",
                                                    "' . @$V['communities'] .
            '",
                                                    "' . str_replace('"', '\\"',
            @$V['content']) . '",
                                                    "' . @$V['created_at'] . '",
                                                    "' . @$V['publish_at'] . '",
                                                    NOW( ) )');

    } else {

        $DB->query('UPDATE `censor_comment` SET `card`     = "' . (intval(@$V['post_id']) ?
            @$V['post_id'] : @$V['card_id']) . '",
                                                 `user`     = "' . @$V['username'] .
            '",
                                                 `IP`       = "' . @$V['ip_address'] .
            '",
                                                 `language` = "' . @$V['language_code'] .
            '",
                                                 `interest` = "' . @$V['communities'] .
            '",
                                                 `title`    = "' . str_replace('"',
            '\\"', @$V['title']) . '",
                                                 `content`  = "' . str_replace('"',
            '\\"', @$V['content']) . '",
                                                 `image`    = "' . @$V['images'] .
            '",
                                                 `create`   = "' . @$V['created_at'] .
            '",
                                                 `publish`  = "' . @$V['publish_at'] .
            '",
                                                 `update`   = NOW( )
                                           WHERE `key`      = "' . @$V['id'] .
            '"');

    }

    record(date('Y-m-d H:i:s') . ' ' . (!@$RS->num_rows ? 'INSERT' : 'UPDATE') .
        ' comment ' . @$V['id'] . "\r\n");

} // foreach


////
///
//  Report Card

record("\r\n" . date('Y-m-d H:i:s') . ' REPORT card' . "\r\n");

curl_setopt_array($cURL, array(

    CURLOPT_URL => "http://api1.vingle.net/api/censor/report_card?from=" . urlencode
        ($F) . "&to=" . urlencode($T),

    CURLOPT_HTTPHEADER => array(
        "X-Vingle-Application-Id: 6dfce2b7ad47686969dcad79f5c35955",
        "X-Vingle-Rest-Api-Token: 1fc9343b9ce0262a36b16f526933183c",
        "Content-Type:            application/json",
        "Accept:                  application/json"),

    CURLOPT_RETURNTRANSFER => 1));

foreach (@$data as $V) {

    @$V['other_reason'] = str_replace('null', '', @$V['other_reason']);

    $DB->query('UPDATE `censor_card`
                   SET    `report` = CONCAT( COALESCE( `report`, "" ), "' . @$V['created_at'] .
        ' | ' . @$V['username'] . ' | ' . @$V['reason'] . ' | ' . (@$V['other_reason'] ?
        @$V['other_reason'] . ' | ' : '') . @$V['id'] . "\r\n" . '" )
                   WHERE `key` = "' . @$V['card_id'] . '"');

    record(date('Y-m-d H:i:s') . ' UPDATE card ' . @$V['card_id'] . "\r\n");

} // foreach


////
///
//  Report Comment

record("\r\n" . date('Y-m-d H:i:s') . ' REPORT comment' . "\r\n");

curl_setopt_array($cURL, array(

    CURLOPT_URL => "http://api1.vingle.net/api/censor/report_comment?from=" .
        urlencode($F) . "&to=" . urlencode($T),

    CURLOPT_HTTPHEADER => array(
        "X-Vingle-Application-Id: 6dfce2b7ad47686969dcad79f5c35955",
        "X-Vingle-Rest-Api-Token: 1fc9343b9ce0262a36b16f526933183c",
        "Content-Type:            application/json",
        "Accept:                  application/json"),

    CURLOPT_RETURNTRANSFER => 1));

foreach (@$data as $V) {

    @$V['other_reason'] = str_replace('null', '', @$V['other_reason']);

    $DB->query('UPDATE `censor_comment`
                   SET    `report` = CONCAT( COALESCE( `report`, "" ), "' . @$V['created_at'] .
        ' | ' . @$V['username'] . ' | ' . @$V['reason'] . ' | ' . (@$V['other_reason'] ?
        @$V['other_reason'] . ' | ' : '') . @$V['id'] . "\r\n" . '" )
                   WHERE `key` = "' . @$V['comment_id'] . '"');

    record(date('Y-m-d H:i:s') . ' UPDATE Comment ' . @$V['comment_id'] . "\r\n");

} // foreach


////
///
//  Target


////
///
//  Request
//fclose($file);


//@mysqli_close( $DB );

sleep(20);

?>
