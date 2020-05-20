<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjectTPI.
*     Page                :  Login form.
*     Brief               :  Login form to include in page
*     Date                :  19.05.2020.
*/
?>

<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-12">
            <div class="card">
                <?php if (isset($erreur["login"])): ?>
                    <div class="card-header bg-danger text-light">Wrong email or password</div>
                <?php else: ?>
                    <div class="card-header">Login</div>
                <?php endif; ?>
                <div class="card-body">
                    <form name="login">
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="username">Username :</label>                                       
                                        <input type="text" class="form-control" id="username" placeholder="Username" name="username" required>
                                        <p id="errorLogin" class="errormsg">Wrong email or password</p>
                                        <p id="errorActivation" class="errormsg">Account not activate</p>
                                </div>
                                <div class="col">
                                    <label for="password">Password :</label>
                                        <input type="password" class="form-control" id="password" placeholder="******" name="password" required>
                                        <p id="errorParam" class="errormsg">Error with the server</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            <button type="submit"  id="login" class="form-control btn btn-outline-primary" name="formLogin">Sign in</button>
                            <a href="./inscription.php">Not register yet ?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>