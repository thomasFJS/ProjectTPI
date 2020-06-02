$(document).ready(() => {
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
    let country = $("#country option:selected").text();
    let birthday = $('#birthday').val();
    let userLogo = $("#userLogo").prop('files').length > 0 ? $('#userLogo').prop('files')[0] : null;
    //Create data to send
    let formData = new FormData();
    formData.append("nickname", nickname);
    formData.append("email", email);
    formData.append("password", password);
    formData.append("verifyPassword", verifyPassword);
    formData.append("country", country);
    formData.append("birthday", birthday);
    formData.append("media[]", userLogo);


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
                case 0 :
                    window.location = "./login.php";
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


