<?php
if(!isset($_SESSION['user'])){
    header("Location: index.php?page=home");
    die();
}
else{
    $user = $_SESSION['user'];
    if($user->role_name == "User") {
        header("Location: index.php?page=home");
        die();
    }
    $productMess = false;
    if (isset($_GET['productMessage'])){
        $productMess = $_GET['productMessage'];
    }

    $contactMess = false;
    if (isset($_GET['contactMessage'])){
        $contactMess = $_GET['contactMessage'];
    }

    $userMess = false;
    if (isset($_GET['userMessage'])){
        $userMess = $_GET['userMessage'];
    }
}
?><div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <div class="col-12 purple">
            <h1 class="my-3 fs-6 text-center">Admin - <?=$user->first_name?> <?=$user->last_name?></h1>
        </div>
        <div class="col-8 d-flex justify-content-around mt-3">
            <a href="#users">User management</a>
            <a href="#products">Products</a>
            <a href="#messages">Message management</a>
            <a href="#poll">Survey results</a>
        </div>
    </div>
</div>

<!--USERS-->
<div class="container" id="users">
<!-- ispis   -->
</div>

<!--Products-->
<div class="container" id="products-admin">
    <div class="col-12 d-flex flex-column align-items-center">
        <?php
        $products = queryFunction("SELECT p.id, p.id_category, p.name,p.price, p.picture_src, p.active, c.name as category FROM product p INNER JOIN category c ON p.id_category = c.id ", true);
        $categories = queryFunction("SELECT * FROM category", true);
        ?>

        <h2 class="text-center fs-3 mt-5 mb-3">Products (<?=count($products)?>)</h2>
        <table class="col-12 text-center">
            <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Picture</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Category</th>
                <th scope="col">Manage</th>
            </tr>
            </thead>
            <tbody class="text-center">
            <?php
            $i = 1;
            foreach ($products as $p):
                ?>
            <form method="POST" action="models/adminPanel/editProduct.php">
                <input type="hidden" name="id" value="<?=$p->id?>">
                <tr class="<?=$p->active == 1 ? "table-success" : "table-danger"?>">
                    <th scope="row"><?=$i++?></th>
                    <td class="col-2"><img src="assets/img/<?=$p->picture_src?>" alt="<?=$p->name?>" class="col-6"/></td>
                    <td><input type="text" name="prName" value="<?=$p->name?>"></td>
                    <td><input type="text" name="prPrice" value="<?=$p->price?>"></td>
                    <td>
                        <select name="cat_id" id="category">
                            <?php foreach ($categories as $cat): ?>
                                <option <?= $cat->id == $p->id_category ? 'selected' : '' ?> value="<?= $cat->id ?>"><?= $cat->name ?></option>
                            <?php endforeach;?>
                        </select>
                    </td>
                    <td><button class="button btn">Save changes</button></td>
                    <td><a href="models/adminPanel/statusProduct.php?table=product&id=<?=$p->id?>&status=<?=$p->active == 1 ? "1" : "0"?>" class="btn btn-<?=$p->active == 1 ? "danger" : "success"?>"><?=$p->active == 1 ? "Deactivate" : "Activate"?></a></td>
                </tr>
            </form>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>

<!--Messages-->
<div class="container" id="messages">
    <div class="col-12 d-flex flex-column align-items-center">
        <?php
        $messages = queryFunction("SELECT * FROM message ", true);
        ?>

        <h2 class="text-center fs-3 mt-5 mb-3">Messages (<?=count($messages)?>)</h2>
        <table class="col-12 text-center">
            <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Name</th>
                <th scope="col">E-mail</th>
                <th scope="col">Message</th>
                <th scope="col">Time</th>
                <th scope="col">Manage</th>
            </tr>
            </thead>
            <tbody class="text-center">
            <?php
            $i = 1;
            foreach ($messages as $m):
                ?>
                <tr>
                    <th scope="row"><?=$i++?></th>
                    <td><?=$m->full_name?></td>
                    <td><?=$m->email?></td>
                    <td><?=$m->text?></td>
                    <td><?=$m->time?></td>
                    <td><a href="models/adminPanel/deleteMessage.php?table=message&id=<?=$m->id?>" class="btn button">Delete</a></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>

<div class="container" id="poll">
<div class="col-12 d-flex flex-column align-items-center">
    <?php
    $quality = queryFunction("SELECT * FROM poll_quality ", true);
    ?>

    <h2 class="text-center fs-3 mt-5 mb-3">Poll result (<?=count($quality)?>)</h2>
    <h3 class="fs-5">Service quality</h3>
    <table class="col-12 text-center">
        <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col">Quality</th>
            <th scope="col">Votes</th>
        </tr>
        </thead>
        <tbody class="text-center">
        <?php
        $i = 1;
        foreach ($quality as $q):
            ?>
            <tr>
                <th scope="row"><?=$i++?></th>
                <td><?=$q->rank_name?></td>
                <td><?=$q->votes?></td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

    <h3 class="fs-5">Media</h3>
    <table class="col-12 text-center">
        <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col">Answer</th>
            <th scope="col">Votes</th>
        </tr>
        </thead>
        <tbody class="text-center">
        <?php
        $interest = queryFunction("SELECT * FROM poll_interest ", true);
        $i = 1;
        foreach ($interest as $in):
            ?>
            <tr>
                <th scope="row"><?=$i++?></th>
                <td><?=$in->name?></td>
                <td><?=$in->votes?></td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>
</div>