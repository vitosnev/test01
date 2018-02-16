function NewsViewModel(){
  var self = this;
  
  self.news = ko.observable();
  self.chosenRowId = ko.observable();
    
  $.getJSON("/parser.php", function(data){
    self.news(data);
  })
  
  self.click = function(row){
    self.chosenRowId(row);
  }
   
}

ko.applyBindings(new NewsViewModel());
