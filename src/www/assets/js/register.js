$(document).ready(() => {
    $('.errormsg').hide();
    $('#registerUser').click(register);
});

/**
 * Register with ajax
 * @param {*} event 
 */
function register(event) {
    if (event) {
        event.preventDefault();
    }
    // Init
    let nickname = $('#nicknameUser').val();
    let email = $("#emailUser").val();
    let password = $("#password").val();
    let verifyPassword = $("#verifyPassword").val();
    
    //Create data to send
    let formData = new FormData();
    formData.append("nickname", nickname);
    formData.append("email", email);
    formData.append("password", password);
    formData.append("verifyPassword", verifyPassword);



    if (nickname.length == 0) {
        $("#nicknameUser").css("border-color", "red");
        $("#nicknameUser").focus();
        return;
    } else {
        $("#nicknameUser").css("border-color", "");
    }

    if (email.length == 0) {
        $("#emailUser").css("border-color", "red");
        $("#emailUser").focus();
        return;
    } else {
        $("#emailUser").css("border-color", "");
    }

    if (password.length == 0) {
        $("#password").css("border-color", "red");
        $("#password").focus();
        return;
    } else {
        $("#password").css("border-color", "");
    }

    if (verifyPassword.length == 0) {
        $("#verifyPassword").css("border-color", "red");
        $("#verifyPassword").focus();
        return;
    } else {
        $("#verifyPassword").css("border-color", "");
    }

    $.ajax({
        method: 'POST',
        url: './app/api/register.php',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,

        success: function(data){
            switch(data.ReturnCode){
                case REGISTER_DONE :
                    window.location = "./login.php";
                    break;
                case REGISTER_FAIL :
                    $('#errorParam').show().delay(3000).fadeOut(1000);                   
                    break;
                case REGISTER_DIFFERENT_PASSWORD:
                    $('#errorDifferentPassword').show().delay(3000).fadeOut(1000);
                    break;
                case REGISTER_PASSWORD_DONT_MATCH_REQUIREMENTS:
                    $('#errorPasswordMatch').show().delay(3000).fadeOut(1000);
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
                    error = error + jqXHR.status + "Can't find register.php";
                break;
            }
            alert(error);
        }
    });
}


