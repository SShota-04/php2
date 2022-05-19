<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カレンダー予約フォーム</title>
	<link rel="stylesheet" href="css/nomalize.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<section class="calendar_sec">
	<div class="calendar_box">
	<?php
	//祝日の読み込み
	$file = new SplFileObject("./syukujitsu.csv"); 
	$file->setFlags(SplFileObject::READ_CSV); 	
	$syuku_array = array();
	foreach ($file as $line) {
		if(isset($line[1])){
			$date = date("Y-m-d",strtotime($line[0]));
			$name = $line[1];
			$syuku_array[$date] = $name;
		}
	}
	
	$week = array('日','月','火','水','木','金','土');	
	$now_month = date("Y年n月"); //表示する年月
	$start_date = date('Y-m-01'); //開始の年月日
	$end_date = date("Y-m-t"); //終了の年月日
	$start_week = date("w",strtotime($start_date)); //開始の曜日の数字
	$end_week = 6 - date("w",strtotime($end_date)); //終了の曜日の数字
	
	echo '<table class="cal">';
	//該当月の年月表示
	echo '<tr>';
	echo '<td colspan="7" class="center">'.$now_month.'</td>';
	echo '</tr>';
	
	//曜日の表示 日～土
	echo '<tr class="day_week">';
	foreach($week as $key => $youbi){
		if($key == 0){ //日曜日
			echo '<th class="sun">'.$youbi.'</th>';
		}else if($key == 6){ //土曜日
			echo '<th class="sat">'.$youbi.'</th>';
		}else{ //平日
			echo '<th>'.$youbi.'</th>';
		}	
	}
	echo '</tr>';
	
	//日付表示部分ここから
	echo '<tr>';
	//開始曜日まで日付を進める
	for($i=0; $i<$start_week; $i++){
		echo '<td></td>';
	}
	//1日～月末までの日付繰り返し
	for($i=1; $i<=date("t"); $i++){
		$set_date = date("Y-m",strtotime($start_date)).'-'.sprintf("%02d",$i);	
		$week_date = date("w", strtotime($set_date));
		
		//土日で色を変える
		if($week_date == 0){
			//日曜日
			echo '<td class="sun ng">'.$i.'</td>';
		}else if($week_date == 6){
			//土曜日
			echo '<td class="sat ng">'.$i.'</td>';
		}else if(array_key_exists($set_date,$syuku_array)){
			//祝日
			echo '<td class="sun ng">'.$i.'</td>';
		}else if($i < $now_date){
			//過去日付はNG
			echo '<td class="ng">'.$i.'</td>';
		}else{
			//平日
			echo '<td data-date="'.$set_date.'" class="ok"><a href="#reserve">'.$i.'</a></td>';
		}	
		if($week_date == 6){
			echo '</tr>';
			echo '<tr>';
		}
	}
	
	//末日の余りを空白で埋める
	for($i=0; $i<$end_week; $i++){
		echo '<td></td>';
	}
	
	echo '</tr>';
	echo '</table>';
	?>
	</div>
</section>

<section class="reserve_sec">
	<div>
		<form action="calendar_create.php" method="POST">
			<h1 id="reserve">Reserve</h1>
			<p>ご予約</p>
			<div>
				<div>get_date：<input type="text" name="get_date" class="date_input"></div>
				<div>name: <input type="text" name="name"></div>
				<div>email: <input type="email" name="email"></div>
				<div>comment: <textarea name="comment"></textarea></div>
			</div>
			<button>送信</button>
			<a href="calendar_read.php">一覧画面</a>
		</form>
	</div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
    <script>

        $(".ok").click(function(){
            let get_date = $(this).data("date");
            $('input[name="get_date"]').val(get_date);
            window.moveTo(0,400);
        });

        $(".pre").click(function(){
            let pre = $(this).data("pre");
            $(".cal_disp div").hide();
            $(".cal_disp .set_cal" + pre).fadeIn();
        });
        
        $(".next").click(function(){
            let next = $(this).data("next");
            $(".cal_disp div").hide();
            $(".cal_disp .set_cal" + next).fadeIn();
            console.log(next);
        });	
    </script>
</body>
</html>

    