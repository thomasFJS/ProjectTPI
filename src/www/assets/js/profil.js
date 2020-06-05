$(document).ready(() => {
    $('#save').click(SaveInfos);
    $('#cancel').click(Cancel);
    $('.errormsg').hide();
});

/**
 * @brief Save user's infos
 * 
 * @param {*} event 
 */
function SaveInfos(event) {
    if (event) {
        event.preventDefault();
    }

    // init
    let nickname = $("#nickname").val();
    let name = $("#name").val();
    let surname = $("#surname").val();
    let userBio = $("#userBio").val();
    let country = $("#userCountry option:selected").attr("id");
    let avatar = $("#avatar").prop('files').length > 0 ? $('#avatar').prop('files')[0] : null;

    //Create data to send
    let formData = new FormData();
    formData.append("nickname", nickname);
    formData.append("name", name);
    formData.append("surname", surname);
    formData.append("userBio", userBio);
    formData.append("country", country);
    formData.append("media[]", avatar);

    if (nickname.length == 0) {
        $("#nickname").css("border-color", "red");
        $("#nickname").focus();
        return;
    } else {
        $("#nickname").css("border-color", "");
    }

    $.ajax({
        method: 'POST',
        url: './app/api/updateProfil.php',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,

        success: function(data){
            switch(data.ReturnCode){
                case INFOS_UPDATED :
                    window.location = "./index.php";
                    alert("Your infos has been updated");
                    break;
                case INFOS_UPDATED_FAIL : 
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
                    error = error + jqXHR.status + "Can't find updateProfil.php";
                break;
            }
            alert(error);
        }
    });
}
/**
 * @brief Cancel the form 
 * 
 * @param {*} event 
 * 
 * @return void
 */
function Cancel(event){
    if (event) {
      event.preventDefault();
    }
    window.location = "./index.php";
  }