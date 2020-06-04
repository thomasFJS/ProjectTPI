$(document).ready(() => {
    $('#save').click(SaveInfos);
    $('.errormsg').hide();
});

/**
 * @brief Login with ajax
 * 
 * @param {*} event 
 */
function SaveInfos(event) {
    if (event) {
        event.preventDefault();
    }

    // init
    let username = $("#username").val();
    let password = $("#password").val();

    if (username.length == 0) {
        $("#username").css("border-color", "red");
        $("#username").focus();
        return;
    } else {
        $("#username").css("border-color", "");
    }

    if (password.length == 0) {
        $("#password").css("border-color", "red");
        $("#password").focus();
        return;
    } else {
        $("#password").css("border-color", "");
    }

    $.ajax({
        method: 'POST',
        url: './app/api/login.php',
        data: {'username': username, 'password': password},
        dataType: 'json',

        success: function(data){
            switch(data.ReturnCode){
                case 0 :
                    window.location = "./index.php";
                    break;
                case 1 :
                    $('#errorParam').show().delay(3000).fadeOut(1000);                   
                    break;
                case 2: 
                    $('#errorLogin').show().delay(3000).fadeOut(1000);
                break;
                case 3:
                    $('#errorActivation').show().delay(3000).fadeOut(1000);
                    break;
                default:
                    alert("-");
                    break;
            }
        },

        error: function (jqXHR){
            error = "Error :";
            switch(jqXHR.status){
                case 200: 
                    error = error + jqXHR.status + "invalid json";
                break;
                case 404:
                    error = error + jqXHR.status + "Can't find login.php";
                break;
            }
            alert(error);
        }
    });
}