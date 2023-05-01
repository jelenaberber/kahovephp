</header>
<div class="container-fluid">
    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html"><img src="assets/img/logo.png" alt="Logo"class="logo"/></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="nav">
                    <?php
                        global $conn;
                        $pages = $conn->query("SELECT path, name FROM page")->fetchAll();
                        foreach ($pages as $p) :
                    ?>
                            <li class="nav-item"><a class="nav-link active link" aria-current="page" href="index.php?page=<?= $p->path?>"><?= $p->name ?></a></li>

                    <?php endforeach;?>
                </ul>
                <ul class="navbar-nav mb-2 mb-lg-0 col-2 d-flex justify-content-around">
                    <?php
                        if(isset($_SESSION['user'])):
                    ?>
                    <li><a href="models/logout.php">Log out</a></li>
                        <?php
                        if($_SESSION['user']->role_name == 'Admin'):
                            ?>
                            <li><a href="index.php?page=admin">Admin panel</a></li>
                        <?php endif;?>
                    <?php else :?>
                    <li><a href="index.php?page=register">Registration</a></li>
                    <li><a href="index.php?page=login">Log in</a></li>
                    <?php endif;?>

                </ul>
                <a class="d-flex" href="index.php?page=cart">
                    <i class="fa-solid fa-basket-shopping basket"></i>
                </a>
            </div>
        </div>
    </nav>
</div>
<span class="line"></span>
</header>