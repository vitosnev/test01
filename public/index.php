
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title>Тест</title>
	<link href="http://bootstrap-3.ru/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="/css/layout.css" media="screen" rel="stylesheet" type="text/css" > 
	
</head>
<body>
	<h1>Новости Ленты.ру</h1>
	<div class="wraptable"> 
	<table>
	  <thead>
	    <tr>
	      <th data-bind="css: {toUp: sortToUpT, toDown: sortToDownT, toNone: sortToUpT == sortToDownT},
	                     click: sortByTime" style="width:130px;">Дата время</th>
	      <th style="width:150px;">Изображение</th>
	      <th data-bind="css: {toUp: sortToUpH, toDown: sortToDownH, toNone: sortToUpH == sortToDownH},
	                     click: sortByHead" style="width:200px;">Название</th>
	      <th style="width:500px;">Краткое описание</th>
	      <th style="width:100px;">Ccылка</th>
	    <tr>
	  </thead>
	  <tbody data-bind="foreach: news">
	    <tr data-bind="css: {selected: $data == $root.chosenRowId()},
	                   click: {single: $root.select, double: $root.viewNew}">
	      <td data-bind="text: time"></td>
	      <td>
	        <img data-bind="attr: {src: picture_path}" width="150">
	      </td>
	      <td data-bind="text: header"></td>
	      <td data-bind="text: small_text"></td>
	      <td>
	        <a data-bind="attr: {href: link}" target="_blank">
	          Lenta.ru
	        </a>
	      </td>
	    </tr>
	  </tbody>
	</table>
	<div class="wraptable_ovrlay" data-bind="css: {loading: isLoad}">
	  <img src="/loading.gif">
	</div>
	</div>
	
	<button class="btn btn-success" data-bind="disable: isLoad, click: $root.refresh">Обновить</button>
	
	<!-- модальное окно -->
	<div id="modal" data-bind="with: newinmodal">
	  <span id="modal_close" onclick="closeWin()">X</span>
	  <div class="time" data-bind="text: time"></div>
	  <div class="image">
	     <img data-bind="attr: {src: picture_path}" width="450">
	  </div>
	  <div class="text" data-bind="text: small_text"></div>
	</div>
  <div id="overlay" onclick="closeWin()"></div>
  	
	<script src="http://knockoutjs.com/downloads/knockout-3.4.2.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="/js/index.js"></script>
</body>
</html>

