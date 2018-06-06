
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
                $('#filterRes').html('Поиск...');
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
