$('.lblInp input').keyup(function() {
  if($(this).val().length > 0){
    $(this).closest('.lblInp input').addClass('filled');
  }
  else{
    $(this).closest('.lblInp input').removeClass('filled');
  }
});