$('#categories').keyup(function(){
    current = $(this).val();
    var arr = current.split(' ');
    res = "";
    arr.forEach(function(a){
      if(a != ""){
        if(a.length >= 2){
            size = a.length / 2;
        }else{
            size = 1;
        }    
        res +="<div class=\"chip m-1\" id=\"" + a +  "\"><input type=\"text\" name=\"categories[]\" class=\"chip__content\" size=\"" + size +"\" readonly value=\"" + a + "\"><botton class=\"button_close\" data-name=\"" + a +  "\"><div class=\"button__line button__line--first\"></div><div class=\"button__line button__line--second\"></div></button></div>";
      }
    })
    $("#res").html(res);
    $('.button_close').click(function(){
        data = $(this).data('name');
        $('#categories').val($('#categories').val().replace(data, '').trim());
        var index = arr.indexOf(data);
        arr.splice(index, 1);
        $("#" + data).remove();
    })
})