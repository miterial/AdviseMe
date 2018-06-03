// Years slider
$( document ).ready(function(){
var yearsSlider = document.getElementById('regular-slider');

noUiSlider.create(yearsSlider, {
  connect: true,
  behaviour: 'tap',
  start: [ 2010, 2017 ],
  range: {
    // Starting at 500, step the value by 500,
    // until 4000 is reached. From there, step by 1000.
    'min': 1955,
    'max': 2018
  },
  pips: {
    mode: 'values',
    values: [1955, 1970, 1985, 2000, 2018],
    density: 15,
    stepped: true
  },
  step:1,
  tooltips: true

});

var yearValues = [

   document.getElementById('min-year'),
   document.getElementById('max-year')

];

yearsSlider.noUiSlider.on('update', function( values, handle ) {
  yearValues[handle].innerHTML = values[handle];
});

//Rating sliders

// IMDB slider 
var ratingSlider1 = document.getElementById('rate-slider1');

noUiSlider.create(ratingSlider1, {
  connect: true,
  behaviour: 'tap',
  start: 0,
  range: {
    'min': 0,
    'max': 10
  },
  step: 0.5
});

var imdb = document.getElementById('rate-text1');

ratingSlider1.noUiSlider.on('update', function( values, handle ) {
  imdb.innerHTML = values[handle];
});

// Kinopoisk slider
var ratingSlider2 = document.getElementById('rate-slider2');

noUiSlider.create(ratingSlider2, {
  connect: true,
  behaviour: 'tap',
  start: 0,
  range: {
    'min': 0,
    'max': 10
  },
  step: 0.5
});

var kinopiosk = document.getElementById('rate-text2');

ratingSlider2.noUiSlider.on('update', function( values, handle ) {
  kinopiosk.innerHTML = values[handle];
});


// AdviseMe Slider
var ratingSlider3 = document.getElementById('rate-slider3');

noUiSlider.create(ratingSlider3, {
  connect: true,
  behaviour: 'tap',
  start: 0,
  range: {
    'min': 0,
    'max': 10
  },
  step: 0.5
});


var adviseme = document.getElementById('rate-text3');

ratingSlider3.noUiSlider.on('update', function( values, handle ) {
  adviseme.innerHTML = values[handle];
});


}); //end document.ready