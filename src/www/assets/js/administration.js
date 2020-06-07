$(document).ready(() => {
    $('#btnModal').click(DisableAccount);
    $('#modalDisable').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)         
        var type = button.data('type')
        $('#modalDisable').modal('show')
        if (type == "disable") {
            var nickname = button.data('nickname') 
            var modal = $(this)
            modal.find('.modal-title').text('Are you sure you want to disable this account')
            modal.find('.modal-body').text('Disable the account : ' + nickname)
            $('#btnModal').attr('name', 'disableUser');
            $('#hiddenModal').attr('name', 'hiddenNick');
            $('#hiddenModal').attr('value', nickname);
        }
    });
});

function DisableAccount(event){
    if (event) {
        event.preventDefault();
    }

    let nickname = $('#hiddenModal').val();

    if(nickname.length == 0){
        $('#errorNickname').show().delay(3000).fadeOut(1000);
        return;
    }
    var formData = new FormData();
    formData.append("nickname", nickname);

    $.ajax({
        method: 'POST',
        url: './app/api/disableAccount.php',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
  
        success: function(data){
            switch(data.ReturnCode){
                case ACCOUNT_DISABLED:
                    window.location = "./administration.php";
                    break;
                case DISABLE_ACCOUNT_FAIL: 
                    $('#errorUpdate').show().delay(3000).fadeOut(1000);
                break;
                default:
                    alert("-");
                    break;
            }
        },
  
        error: function (jqXHR){
            error = "Error :";
            switch(jqXHR.status){
                case INVALID_JSON: 
                    error = error + jqXHR.status + "invalid json";
                break;
                case FILE_NOT_FOUND:
                    error = error + jqXHR.status + "Can't find createItinerary.php";
                break;
            }
            alert(error);
        }
    });
}