<div class="container-fluid" style="background-color: #867fce; margin-bottom: 3%;">
    <nav class="container navbar navbar-expand-lg navbar-light">
        <div class="navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link text-light" href=".\index.php">Accueil</a>
                </li>
            </ul>
            <span class="navbar-text">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href=""><img src="<?php echo TSessionController::getUserLogged()->Logo ?>" alt="" width="50px"></a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href=".\profil.php">Profil</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href=".\logout.php">Logout</a>
                        </div>
                    </li>
                </ul>
            </span>
        </div>
    </nav>
</div>