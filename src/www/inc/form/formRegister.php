<div id="formInscription">
    <div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Register as new user</div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="nickname">Nickname :</label>
                                    <?php if (isset($erreur["nickname"])): ?>
                                        <input type="text" class="form-control is-invalid" id="nicknameUser" placeholder="Error nickname" name="nicknameUser" required>
                                        <div class="invalid-feedback">Please enter a valid nickname</div>
                                    <?php else: ?>
                                        <input type="text" class="form-control" id="nickname" placeholder="Nickname" name="nicknameUser" required value="<?php if(isset($nicknameUser)){echo $nicknameUser;}?>">
                                    <?php endif; ?>
                                </div>
                            </div>                       
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="emailUser">Email :</label>
                                    <?php if (isset($erreur["email"])): ?>
                                        <input type="email" class="form-control is-invalid" id="emailUser" placeholder="Email" name="emailUser" required>
                                        <div class="invalid-feedback"><?= $erreur["email"] ?></div>
                                    <?php else: ?>
                                        <input type="email" class="form-control" id="emailUser" placeholder="Email" name="emailUser" required value="<?php if(isset($emailUser)){echo $emailUser;}?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="password">Password :</label>
                                    <?php if (isset($erreur["password"])): ?>
                                        <input type="password" class="form-control is-invalid" id="password" placeholder="******" name="password" required>
                                        <div class="invalid-feedback"><?=  $erreur["password"] ?></div>
                                    <?php else: ?>
                                        <input type="password" class="form-control" id="password" placeholder="******" name="password" required>
                                    <?php endif; ?>
                                </div>
                                <div class="col">
                                    <label for="verifyPassword">Confirm Password :</label>
                                    <?php if (isset($erreur["password"])): ?>
                                        <input type="password" class="form-control is-invalid" id="verifyPassword" placeholder="******" name="verifyPassword" required>
                                        <div class="invalid-feedback"><?=  $erreur["password"] ?></div>
                                    <?php else: ?>
                                        <input type="password" class="form-control" id="verifyPassword" placeholder="******" name="verifyPassword" required>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="countryUser">Country :</label>
                                    <select name="country" id="country" size="1" class="custom-select">
                                    <?php 
                                        $countryController = new TCountryController();
                                        foreach ($countryController->getAllCountry() as $country) {
                                            echo "<option id=". $country->Code ."> " . $country->Name . "</option>";
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                <label for="start">Birthday :</label>

                                <input type="date" id="birthday" name="birthdayUser"
                                    value="2018-07-22" min="1900-01-01" max="2018-09-01" class="input-group form-control date">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                                <label for="">&nbsp;</label>
                                <input type="submit" class="form-control btn btn-outline-primary" id="registerUser" onclick="register()" value="Register" name="registerUser">
                                <a href="./index.php">Already register? Log in</a>
                        </div>
                        
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>