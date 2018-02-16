
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title>Тест</title>
	<link href="/css/layout.css" media="screen" rel="stylesheet" type="text/css" > 
</head>
<body>
	<h2>Новости Ленты.ру</h2>
	<table>
	  <thead>
	    <tr>
	      <th>Дата/время</th>
	      <th>Изображение</th>
	      <th>Название</th>
	      <th>Краткое описание</th>
	      <th>Ссылка</th>
	    <tr>
	  </thead>
	  <tbody data-bind="foreach: news">
	    <tr data-bind="css: {selected: $data == $root.chosenRowId()},
	                   click: $root.click">
	      <td data-bind="text: time"></td>
	      <td>
	        <img data-bind="attr: {src: picture_path}" width="150">
	      </td>
	      <td data-bind="text: header"></td>
	      <td data-bind="text: small_text"></td>
	      <td>
	        <a data-bind="attr: {href: link}" target="_blank">
	          Cсылка
	        </a>
	      </td>
	    </tr>
	  </tbody>
	</table>
	<script src="http://knockoutjs.com/downloads/knockout-3.4.2.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="/js/index.js"></script>
</body>
</html>

