
// получение всех отмеченных жанров для отправки
$(document).ready(function() {
	$('#filter_form').submit(function(e){
		e.preventDefault();
		var filter = $('#filter_form');

		$("#filter_form .yearVal").each(function(i,v){
			console.log('yearVal');
		    $("#filter_form").append(
		        $("<input type='hidden' />").attr({
		            name: $(this).attr('id'),
		            value: $(this).text()
		        })
		    )

		});

		$.ajax({
			url:filter.attr('action'),
			data:filter.serialize(),
			type:filter.attr('method'), // POST
			beforeSend: function() {
                $('#filterRes').html('beforeSend');
            },
		     success: function(data){                
		     		console.log('success');
		            $('#filterRes').html(data);
		     },
     		error: function(jqXHR, textStatus, errorThrown) {
                console.log('error: ' + jqXHR.status);
            },
		});
	});
});
	

var genresChecked = [];
var countriesChecked = [];

$(document).on('change', '.genreToggle', function() {
	    var req = $(this).val();
    if(this.checked) {
	    genresChecked[genresChecked.length] = req;
		console.log(genresChecked);
    }
    else {
    	delete genresChecked.remove(req);
		console.log(genresChecked);
    }
});

$(document).on('change', '.countryToggle', function() {
	    var req = $(this).val();
    if(this.checked) {
	    countriesChecked[countriesChecked.length] = req;
		console.log(countriesChecked);
    }
    else {
    	delete countriesChecked.remove(req);
		console.log(countriesChecked);
    }
});


// Удаление элемента вместе с индексом
Array.prototype.remove = function(value) {
    var idx = this.indexOf(value);
    if (idx != -1) {
        // Второй параметр - число элементов, которые необходимо удалить
        return this.splice(idx, 1);
    }
    return false;
}