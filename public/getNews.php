<?php
header('Content-type: text/html; charset=utf-8');

$url = $_GET['path'];
$doc  = new DOMDocument();
	
$ch = curl_init();
$new = array();
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$news = curl_exec($ch);
curl_close($ch);

$page = new DOMDocument();
@$page ->loadHTML('<?xml encoding="utf-8" ?>'.$news);

$time_nodes = $page->getElementsByTagName("div");          // вытаскиваем время 
foreach($time_nodes as $time_node){
	if ($time_node->getAttribute("class")!="b-topic__info") continue;
	$time = $time_node->childNodes[0]->getAttribute("datetime");
}
//echo $time."<br>";
if (empty($time)) return;
$datetime = new DateTime($time);
$datetime->setTimezone(new DateTimeZone('Europe/Moscow'));
setlocale (LC_TIME, 'ru_RU.UTF-8', 'Rus');
$new["time"] = strftime("%H:%M %d %B %G",$datetime->format('U'));

$image_nodes = $page->getElementsByTagName("img");       // вытаскиваем картинку
foreach($image_nodes as $image_node){
	//if ($image_node->getAttribute("class")!="g-picture") continue;
	if ($image_node->getAttribute("rel")!="image_src") continue;
	$picture_path = $image_node->getAttribute("src");
}
if (empty($picture_path)) $picture_path="";
$new["picture_path"] = $picture_path;
		
$nodes = $page->getElementsByTagName("div");							// Вытаскиваем текст
foreach($nodes as $node){
	if ($node->getAttribute("class")!="b-text clearfix js-topic__text") continue;
	$small_text = $node->nodeValue;
}
//echo $small_text."<br><br>";
$new["small_text"] = $small_text;

echo json_encode($new);
?>
