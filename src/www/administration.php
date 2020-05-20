<?php
/*
*     Auteur              :  Fujise Thomas.
*     Projet              :  game.
*     Page                :  Administration.
*     Description         :  Page d'administration.
*     Date début projet   :  04.09.2019.
    
*/
require_once("./inc/function.php");

$deleteUser = filter_input(INPUT_POST, "deleteUser");

if($deleteUser)
{
    $nickToDelete = filter_input(INPUT_POST, "hiddenNick");
    deleteUser($nickToDelete);
}

$nbUser = count(getAllUser());
$userPerPage = 5;
$nbPage = ceil($nbUser/$userPerPage);

if(isset($_GET['page'])){
    $actualPage = intval($_GET['page']);

    if($actualPage>$nbPage){
        $actualPage=$nbPage;
    }
}
else{
    $actualPage = 1;
}

$firstUser = ($actualPage-1)*$userPerPage;
?>
<!DOCTYPE html>
<html lang="FR" dir="ltr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <title>Administration</title>
</head>
<body>
<?php
    //Affiche une navbar selon si on est log ou non.
    if (isLogged()) {
        if (isAllowed("administrateur")) {
            include "navbar/navbarAdmin.php";
        }
        else {
            header("Location: .\index.php");
            exit;
        }
    } 
    else {
        include "navbar/navbarNotLogged.php";
    }
?>
    <div id="panelAdmin">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nickname</th>
                    <th scope="col">Email</th>
                    <th scope="col">Country</th>
                    <th scope="col">Birthday</th>
                    <th scope="col">Activation</th>
                    <th scope="col">Role</th>
                    <th scope="col">Action</th>                   
                </tr>
            </thead>           
        <?php foreach(getUserPerPage($firstUser ,$userPerPage) as $user): ?>
                <tr>
                    <td><?php echo $user->Nickname;?></td>
                    <td><?php echo $user->Email;?></td>
                    <td><?php echo $user->Country;?></td>
                    <td><?php echo $user->Birthday;?></td>
                <?php if($user->Activation == 1): ?>              
                    <td>Activé</td>                   
                <?php else: ?>                
                    <td>Désactivé</td>
                <?php endif; ?>

                <?php switch($user->Role){
                    case 1:
                        echo '<td>Utilisateur</td>';
                    break;

                    case 2:
                        echo "<td>Admin</td>";
                    break;
                } ?>
                    <td><a href="#" class="btn btn-danger" data-type="delete" data-nickname="<?php echo $user->Nickname;?>" data-target="#modalDelete" data-toggle="modal">Delete</a></td>              
                </tr>
            <?php endforeach; ?>    
        </table>
        <?php
            echo '<p align="center"> Page : ';
            for($i=1; $i<=$nbPage; $i++){
                if($i==$actualPage){
                echo ' [ '.$i.' ] ';
                }
                else{
                    echo ' <a href="administration.php?page='.$i.'">'.$i.'</a>';
                }
            }
            echo '</p>';
        ?>
    </div>
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">-</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                -
            </div>
            <div class="modal-footer">
                <form action="" method="post">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <input id="btnModal" class="btn btn-success" type="submit" name="" value="Delete">
                    <input id="hiddenModal" type="hidden" name="" value="">
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script>

$('#modalDelete').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)         
        var type = button.data('type')
        $('#modalDelete').modal('show')
        if (type == "delete") {
            var nickname = button.data('nickname') 
            var modal = $(this)
            modal.find('.modal-title').text('Are you sure you want delete this user')
            modal.find('.modal-body').text('Delete the user : ' + nickname)
            $('#btnModal').attr('name', 'deleteUser');
            $('#hiddenModal').attr('name', 'hiddenNick');
            $('#hiddenModal').attr('value', nickname);
        }
    });
</script>