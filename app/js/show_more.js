
window.onload = function(){
  var ul = $('.toggles__long');
  var height = 719;
  $('#show_more').on('click', function() {
      if (ul.css('height') == '140px') {
        $(this).text('Скрыть');
        ul.animate({
          height: height + "px"
        }, 300);
      } else {
        $(this).text('Показать больше');
        ul.animate({
          height: "140px"
        }, 300);
      }
    })
}