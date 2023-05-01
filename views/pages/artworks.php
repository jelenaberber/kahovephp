<main>
    <div class="container-fluid mt-5">
        <h1 class="text-center blueLetters">Artworks</h1>
        <span class="dot mb-5"></span>
        <div class="row d-flex justify-content-center col-12 flex-direction-row">
            <select class="form-select mb-5 mx-2 ddl" id="sort">
                <option value="0">Sort</option>
                <option value="1">By price asc</option>
                <option value="2">By price desc</option>
            </select>
            <select class="form-select mb-5 ddl mx-2" id="categories">
                <option value="0">Categories</option>
                <?php
                global $conn;
                $category = $conn->query("SELECT * FROM category")->fetchAll();
                foreach ($category as $c) :
                    ?>
                    <option value="<?= $c->id?>"><?= $c->name?></option>
                <?php endforeach;?>
            </select>
            <input type="search" id="search" name="search" placeholder="Search" class="col-1 mx-2">
        </div>
        <div class="row d-flex justify-content-center">
            <div class="arts d-flex flex-wrap col-9 justify-content-around" id="products">
                <!--Ispis proizvoda-->
            </div>

        </div>
    </div>
</main>