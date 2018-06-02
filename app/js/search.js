
// получение всех отмеченных жанров для отправки
$("#submit").on('click',function() {
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