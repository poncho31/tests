
$.ajax( {
    url: "https://en.wikipedia.org/w/api.php?action=query&origin=*&prop=extracts&format=json&exintro=&titles=Stack%20Overflow",
    dataType: 'json',
    type: 'POST',
    headers: { 'Api-User-Agent': 'Example/1.0' },
    datatype: 'JSONP',
	crossDomain: true,
    success: function(data) {
    	var item = data.query.normalized[0].from;
    	console.log(item);
    for (var i = 0; i < item.length; i--) {
      console.log(data.query.pages['21721040'].title);
      $('.add').append(data.query.pages[i].extract);
      $('div.add').append('111');	
    }
    }
} );


		$.ajax({
			url: "https://fr.wikipedia.org/w/api.php?origin=*",
			type: "POST",
			datatype: 'json',
			crossDomain: true,
			headers: { 'Api-User-Agent': 'Example/1.0' },
			data: { 
                  format: "json", 
                  action: "query",
                  generator: "search",
                  gsrlimit: "100",
                  prop: "pageimages|extracts",
                  pilimit: "20",
                  exintro: "5",
                  explaintext: "4",
                  exsentences: "4",
                  exlimit: "max",
                  origin: '*',                 // CORS
                  gsrsearch: 'gilles'   // search term (coming from Vue instance)
            },
                success: function(data) {
			      console.log(data.query.pages);
			      // alert('2');
			      $('.add p').append(data.query.pages);
			    }
        })


$(document).ready(function(){
 
    $.ajax({
        type: "GET",
        url: "http://en.wikipedia.org/w/api.php?action=parse&format=json&prop=text&section=0&page=Jimi_Hendrix&callback=?",
        contentType: "application/json; charset=utf-8",
        async: false,
        dataType: "json",
        success: function (data, textStatus, jqXHR) {
 
            var markup = data.parse.text["*"];
            var blurb = $('<div></div>').html(markup);
 
            // remove links as they will not work
            blurb.find('a').each(function() { $(this).replaceWith($(this).html()); });
 
            // remove any references
            blurb.find('sup').remove();
 
            // remove cite error
            blurb.find('.mw-ext-cite-error').remove();
            $('#article').html($(blurb).find('p'));
 
        },
        error: function (errorMessage) {
        }
    });
});
