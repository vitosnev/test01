<?php
/**
 * parser.php
 * распарсим ленту
 */
 	
 	$news_array = array();
 	
	$path = "https://lenta.ru"; 
	$url = $path."/parts/news";	// путь к странице
	$doc  = new DOMDocument();
	
	$ch = curl_init();
	//curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	$data = curl_exec($ch);
	curl_close($ch);
	
	@$doc->loadHTML('<?xml encoding="utf-8" ?>'.$data);											// Загружаем в парсер
	
	$searchNodes = $doc->getElementById('more'); // Ищем элемент с id="more"
	
	
	foreach($searchNodes->childNodes as $node){
		$new = array();
		if ($node->getAttribute("class")!=="item news") continue; // Пропускаем рекламные вставки
		if ($node->firstChild->firstChild->getAttribute("class")=="item__rubric item__rubric_logo-motor") continue; // Пропускаем с motor 
		$link_node =	$node->childNodes[1]->firstChild->firstChild;
		$link = $link_node->getAttribute("href"); 
		$header = $link_node->nodeValue;
		//echo $link."<br>";
		$new["link"]="https://lenta.ru".$link;				// получаем ссылку на новость
		$new["header"]=$header;   // и заголовок
		//echo $header."<br>";
		$url = $path.$link;
		$ch = curl_init();
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
		if (empty($time)) continue;
		$datetime = new DateTime($time);
		$datetime->setTimezone(new DateTimeZone('Europe/Moscow'));
		$new["time"] = $datetime->format('d.m.Y H:i');
		
		$image_nodes = $page->getElementsByTagName("img");       // вытаскиваем картинку
		foreach($image_nodes as $image_node){
			//if ($image_node->getAttribute("class")!="g-picture") continue;
			if ($image_node->getAttribute("rel")!="image_src") continue;
			$picture_path = $image_node->getAttribute("src");
		}
		if (empty($picture_path)) $picture_path="";
		$new["picture_path"] = $picture_path;
		//echo $picture_path."<br>";
		
		$nodes = $page->getElementsByTagName("div");							// Вытаскиваем текст
		foreach($nodes as $node){
			if ($node->getAttribute("class")!="b-text clearfix js-topic__text") continue;
			$small_text = $node->childNodes[0]->nodeValue;
		}
		//echo $small_text."<br><br>";
		$new["small_text"] = $small_text;
		
		$news_array[] = $new;
	}
	
	echo json_encode($news_array);
?>
