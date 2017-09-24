$('#status-button').on('click',function (event) {

    var status=document.getElementById('status-value').value;

    $.ajax({
        method:'POST',
        url:url,
        data:{status:status,user_id:user_id,_token:token},
        success: function(data) {
            var response = data['status'];
            if (response) {
                new Noty({
                    type: 'success',
                    layout: 'bottomLeft',
                    text: 'Your status has been updated !'

                }).show();
            }
            var button_delete="<i class='fa fa-close' aria-hidden='true' ></i>";
            var button_edit="<i class='fa fa-edit' aria-hidden='true'></i>";

           $('#status-form').text('" '+data['statusText']+' "').addClass('status-text');
            $('#delete-status').html(button_delete);
            $('#edit-status').html(button_edit);
        }

    });
});
$(document).ready(function () {
$('#status').mouseover(function() {
    $('#edit-status-buttons').css('display','inline')
});
    $('#status').mouseout(function() {
        $('#edit-status-buttons').css('display','none')
    });
});

// On delete Status function
$('#delete-status').on('click',function (event) {
    var conf=confirm("Do you want to delete status?");
    alert(conf);
    if(conf) {
        $.ajax({
            method: 'POST',
            url: url_delete,
            data: {user_id: user_id, _token: token},
            success: function (data) {
                $('#status-form').hide();
                $('#edit-status-buttons').remove();

                var response = data['status'];
                if (response) {
                    new Noty({
                        type: 'success',
                        layout: 'bottomLeft',
                        text: 'Your status has been deleted !'

                    }).show();
                }
            }
        });
    }

});

// On delete Status function

$('#edit-status').on('click',function (event) {
    var value=document.getElementById('status-form').dataset['value'];
    $('#status-form').remove();
    $('#edit-status-buttons').remove();
    $('#status-form-on-delete').css('display','inline');
    $('#status-form-on-delete').attr("id","status-form");
    $('#status-value').val(value);
});

// On delete user from friend list function
$('#delete-friend-main').on('click',function (event) {
    var conf=confirm("Do you want to delete "+user_name+" from friend list?");
   if(conf) {
       $.ajax({
            method: 'POST',
            url: url_unfriend,
            data: {user_id: user_id, _token: token},
           success: function (data) {

               var response = data['status'];
               if (response) {
                   $('#show_friend_status').hide();
                   $('#delete-friend-main').text('Deleted from your friend list').css('color','green');
                   new Noty({
                       type: 'success',
                       layout: 'bottomLeft',
                       text: user_name+' was deleted from your friend list!'

                   }).show();
               }
           }
       });
   }

});

// On delete user image function
$('.delete_mage').on('click',function (event) {
   var conf=confirm("Do you want to delete this image?");
    var image_id=$(this).data('photo-id');
    if(conf) {
        $.ajax({
            method: 'POST',
            url: url_delete_user_image,
            data: {user_id: user_id,image_id:image_id, _token: token},
            success: function (data) {
                var response = data['status'];
                if (response) {
                    location.reload();
                    new Noty({
                        type: 'success',
                        layout: 'bottomLeft',
                        text: 'Image was deleted!'
                    }).show();
                }
            }
        });
    }

});