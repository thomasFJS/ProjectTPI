$(document).ready(function(){
    $('#send').click(validateLogin);
    $('.errormsg').hide();
});

function validateLogin(event){
    if(event)
        event.preventDefault();
    
    var email = $('#emailUser').val();
    var pwd = $('#password').val();

    if(pwd.length ==0){
        $("#pwd").css("border-color", "red");
        $("#pwd").focus();
        //show error
        return;
    }

    if (email.length == 0){
        
        $("#emailUser").css("border-color", "red");
        
        $("#emailUser").focus(); 
        
        return;
    }
    else{
        $("#emailUser").css("border-color", "");
    }

    $.ajax({
        method: 'POST',
        url: 'validateLogin.php',
        data: {'email': email, 'password': pwd},
        dataType: 'json',

        success: function(data){
            switch(data.ReturnCode){
                case 0 :
                    window.location = `./connectUser.php?email=${email}`;
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
                    error = error + jqXHR.status + "Can't find validateLogin.php";
                break;
            }
            alert(error);
        }
    });
}