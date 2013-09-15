<?php
$flag = true;
$vote_list = array(1 => 'Пирог',2 => 'Кекс', 3 => 'Каравай', 4 => 'Хлеб');

$ip_list = json_decode(file_get_contents('ip.json'));
foreach($ip_list as $ip){
	if($_SERVER['REMOTE_ADDR']==$ip){$flag = false; }else $ip_list[] = $_SERVER['REMOTE_ADDR'];
}
$vote = json_decode(file_get_contents('data.json'), true);


if(isset($_POST['id'])){
	$id = (int)$_POST['id'];
	if($flag&&$id>0&&$id<=4){
		$vote[$id]++;
		file_put_contents('ip.json', json_encode($ip_list));
		if(file_put_contents('data.json', json_encode($vote))){
			$ms = 'Выш голос успешно защитан';
		}else $ms = 'Ошибка подключения к БД';
	}else  $ms = 'Вы уже голосовали';
}




?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Простая голосовалка на PHP</title>
</head>
<body>
<style>
body{margin:50px}
label{position:relative;display:block;padding:10px;margin-left:100px}
label span{width:100px;text-align:right;position:absolute;left:-100px}
img{margin: 25px}
</style>
<h1>Простая голосовалка на PHP</h1>
<form action="" method="post">
<?php foreach($vote_list as $id => $name){
	echo '<label><span>'.$name.'</span><input type="radio" name="id" value="'.$id.'"></label>';
}?>
<p><?php echo $ms;?></p>
<input type="submit" value="Голосовать"><br>
<img src="https://chart.googleapis.com/chart?cht=p3&chs=370x155&chd=t:<?php echo join(",",$vote)?>&chl=<?php foreach($vote as $k => $vv) echo $vote_list[$k].' '.$vv."|" // echo join("|",$vote_list)?>" alt="" align="left">
</form>
</body>
</html>