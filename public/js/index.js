ko.bindingHandlers.click = {
  init: function(element, valueAccessor, allBindingsAccessor, viewModel, context) {
    var accessor = valueAccessor();
    var clicks = 0;
    var timeout = 200;

    $(element).click(function(event) {
      if(typeof(accessor) === 'object') {
        var single = accessor.single;
        var double = accessor.double;
        clicks++;
        if (clicks === 1) {
            setTimeout(function() {
                if(clicks === 1) {
                    single.call(viewModel, context.$data, event);
                } else {
                    double.call(viewModel, context.$data, event);
                }
                clicks = 0;
            }, timeout);
        }
      } else {
        accessor.call(viewModel, context.$data, event);
      }
    });
  }
};

function NewsViewModel(){
  var self = this;
  
  self.news = ko.observable();
  self.chosenRowId = ko.observable();
  self.newinmodal = ko.observable();
  
  self.refresh = function(){
    $.getJSON("/parser.php", function(data){
      self.news(data);
    });
  }
    
  $.getJSON("/parser.php", function(data){
    self.news(data);
  })
  
  self.select = function(row){
    self.chosenRowId(row);
  }
  
  self.viewNew = function(row){
    $.getJSON('/getNews.php', {path: row.link}, function(data){
      self.newinmodal(data);
      
      viewNew();
    });        
  }
}

ko.applyBindings(new NewsViewModel());

viewNew = function(){
  $('#overlay').fadeIn(400, function(){
    $('#modal').css('display', 'block')
               .animate({opacity: 1, top: '50%'}, 200);
  });
}


closeWin = function(){
  $('#modal')
  .animate({opacity: 0, top: '45%'}, 200,
    function(){
      $(this).css('display','none');
      $('#overlay').fadeOut(400);
    }
  );
}

