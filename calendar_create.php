<?php

//var_dump($_POST);
//exit();

//データの受け取り
$getdate = $_POST["get_date"];
$name = $_POST["name"];
$email = $_POST["email"];
$comment = $_POST["comment"];

//データ１件を１行にまとめる（最後に改行を入れる）
$write_data = "{$getdate} {$name} {$email} {$comment} \n";

//ファイルが開く、引数が'a'である部分に注目
$file = fopen('reserve_data/data.csv', 'a');
//ファイルをロックする
flock($file, LOCK_EX);

//指定したファイルに指定したデータを書き込む
fwrite($file, $write_data);

//ファイルのロックを解除する
flock($file, LOCK_UN);
//ファイルを閉じる
fclose($file);

//データ入力画面に移動する
header("Location:calendar.php");

?>