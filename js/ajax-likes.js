$('.like').on('click',function (event) {
    var itemId=event.target.dataset['like'];
    var isLike=event.target.previousElementSibling==null ? true:false;
    $.ajax({
        method:'POST',
        url:url,
        data:{isLike:isLike,itemId:itemId,moduleId:moduleId,moduleName:moduleName,_token:token}
    }).done(function () {
        event.target.innerText=isLike ?event.target.innerText=='Like'?'You like this post':'Like':event.target.innerText=='Dislike'?'You dislike this post':'Dislike';
    if(isLike){
        event.target.nextElementSibling.innerText='Dislike';
    }else{
        event.target.previousElementSibling.innerText='Like';
    }
    });
});

//Functionality fot LIKE/DISLIKE for ajax loaded items
function actionLike(id,state){
   var itemId=id;
    if(state){
        var btn_text_sibling=$('.button_dislike_'+itemId).text();
        var btn_text=$('.button_like_'+itemId).text();
        var icon_text=$('#like_icon_'+itemId).text();
        var dislike_icon_text=$('#dislike_icon_'+itemId).text();
    }else {
        var btn_text_sibling = $('.button_like_' + itemId).text();
        var btn_text = $('.button_dislike_' + itemId).text();
        var icon_text=$('#dislike_icon_'+itemId).text();
        var dislike_icon_text=$('#like_icon_'+itemId).text();
    }
        var isLike=state;
        $.ajax({
            method:'POST',
            url:url,
            data:{isLike:isLike,itemId:itemId,moduleId:moduleId,moduleName:moduleName,_token:token}
        }).done(function () {
if(state) {
    if(btn_text=='Like'){
        if(btn_text_sibling!='Dislike'){
            $('.button_dislike_'+itemId).text('Dislike');
            if(dislike_icon_text=='0'){
                $('#dislike_icon_'+itemId).text('0');
            }else{
                dislike_icon_text=+dislike_icon_text-1;
                $('#dislike_icon_'+itemId).text(dislike_icon_text);
            }
        }
            $('.button_like_'+itemId).text('You like this post');
            icon_text=+icon_text+1;
            $('#like_icon_'+itemId).text(icon_text);
    }else{
        $('.button_like_'+itemId).text('Like');
        icon_text=+icon_text-1;
        $('#like_icon_'+itemId).text(icon_text);
    }
}else {

    if(btn_text=='Dislike'){
        if(btn_text_sibling!='Like'){
            $('.button_like_'+itemId).text('Like');
            $('.button_dislike_'+itemId).text('You dislike this post');
            if(dislike_icon_text=='0'){
                $('#like_icon_'+itemId).text('0');
            }else {
                dislike_icon_text = +dislike_icon_text - 1;
                $('#like_icon_'+itemId).text(dislike_icon_text);
            }
        }
            $('.button_dislike_'+itemId).text('You dislike this post');
            icon_text=+icon_text+1;
            $('#dislike_icon_'+itemId).text(icon_text);

            }
                else{
                    $('.button_dislike_'+itemId).text('Dislike');
                    if(dislike_icon_text=='0'){
                        $('#dislike_icon_'+itemId).text('0');
                    }else{
                        dislike_icon_text=+dislike_icon_text-1;
                        $('#dislike_icon_'+itemId).text(dislike_icon_text);
                    }
                }
            }
        });
}