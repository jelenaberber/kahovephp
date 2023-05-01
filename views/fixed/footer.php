<footer>
    <div class="container-fluid blue mt-5 py-5">
        <div class="col-12 fut" id="menu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex flex-row justify-content-center" id="nav">
                <?php
                global $conn;
                $pages = $conn->query("SELECT path, name FROM page")->fetchAll();
                foreach ($pages as $p) :
                    ?>
                    <li class="nav-item mx-5"><a class="nav-link active link" aria-current="page" href="index.php?page=<?= $p->path?>"><?= $p->name ?></a></li>

                <?php endforeach;?>
                <li class="nav-item mx-5"><a class="nav-link active link" aria-current="page" href="dokumentacija.pdf">Dokumentacija</a></li>
            </ul>
        </div>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script src="assets/js/main.js"></script>
</body>
</html>