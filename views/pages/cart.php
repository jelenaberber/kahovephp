<?php
if(!isset($_SESSION['user'])){
    header("Location: index.php?page=register");
    die();
}
?>
<div class="container-fluid mt-5" id="print">
    <?php
    global $conn;
    $id_user = $_SESSION['user']->id;
    $query = $conn->prepare("SELECT p.name, p.picture_src, p.price, c.amount, c.id, u.first_name, u.last_name, u.email 
                                    FROM product p INNER JOIN cart_content c ON p.id = c.id_product 
                                    INNER JOIN user u ON c.id_user=u.id 
                                    WHERE c.id_user = ? AND c.active = 1");
    $query->execute([$id_user]);
    $products = $query->fetchAll();
    $i = 1;
    if ($products == null):
        ?>
        <div class="row d-flex justify-content-center flex-column align-items-center">
            <h1 class="blueLetters text-center mt-5">Your cart is empty</h1>
            <img src="assets/img/empty_cart.jpg" alt="EmptyCart" class="col-lg-6 col-md-10 col-sm-12 mt-5">
            <button class="btn button col-lg-2 col-md-3 mt-5"><a href="artworks.html">Go back to shopping</a></button>
        </div>
    <?php else:?>
    <div class="container-fluid mt-5 d-flex flex-column align-items-center">
        <h1 class="text-center blueLetters">Products</h1>
        <span class="dot mb-5"></span>
        <div class="col-12 d-flex flex-column justify-content-center align-items-center">
            <table class="col-12 d-flex flex-wrap text-center">
                <tbody id="printProductsInCart">
    <?php foreach ($products as $p):?>
        <tr class="product-<?= $p->id ?>">
        <th scope="row"><?=$i++?></th>
        <td class="col-lg-2 col-sm-10"><img src="assets/img/<?= $p->picture_src ?>" alt="<?= $p->name ?>" class="col-5 pt-3"/></td>
        <td class="col-lg-2 col-sm-5"><?= $p->name ?></td>
        <td class="col-lg-2 col-sm-5"><?= $p->price ?>.00$</td>
        <td class="col-lg-2 col-sm-5">
            <button class="btn button plus" data-plus="<?= $p->id ?>" ">
                <i class="fa-solid fa-plus"></i>
            </button>
            <p class="amount-<?= $p->id ?>" data-amount="<?= $p->amount ?>"><?= $p->amount ?></p>

            <button class="btn button minus" data-minus="<?= $p->id ?>">
                <i class="fa-solid fa-minus"></i>
            </button>
        </td>
        <td class="col-lg-2 col-sm-5"><button class="btn button deleteItem" data-delete="<?= $p->id ?>">Delete from cart</button></td>
        </tr>
        <?php
        error_reporting(E_ALL ^ E_NOTICE);
        $totalPrice += $p->amount * $p->price;
        ?>
    <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <div class="container mt-5" id="form">
            <div class="col-12 d-flex flex-wrap justify-content-between">
                <form id="order" class="col-lg-6 col-md-10 py-5" action="models/oderForm.php" method="POST">
                    <input type="hidden" name="totalPrice" value="<?= $totalPrice + 50?>">
                    <div class="container-fluid col-12">
                        <div>
                            <input type="text" name="name" id="name" class="container brd-none  py-3" value="<?= $p->first_name .' '.$p->last_name?>"/>
                            <span id="spanName" class="span"></span>
                        </div>
                        <div>
                            <input type="text" name="email" id="email" class="container brd-none py-3 mt-2" value="<?= $p->email ?>"/>
                            <span id="spanEmail" class="span"></span>
                        </div>
                        <div>
                            <input type="text" id="address" name="address" class="container brd-none py-3 mt-2" placeholder="City and address"/>
                            <span id="spanAddress" class="span"></span>
                        </div>
                        <div class="d-flex align-items-center flex-column py-3 mt-5">
                            <input type="submit" value="Order" class="btn button"/>
                        </div>
                    </div>
                </form>

                <div class="col-lg-4 col-md-10 purple" id="bill">
                    <h1 class="text-center blueLetters pt-3">Order details</h1>
                    <p class="px-5 fs-5 py-3">Subtotal: <?= $totalPrice ?>.00$</p>
                    <p class="px-5 fs-5 py-3">Shipping: 50.00$</p>
                    <p class="px-5 fs-5 py-3">Total: <?= $totalPrice + 50?>.00$</p>
                </div>
            </div>
        </div>
    <?php endif;?>
</div>

</div>

<div class="container-fluid" id="modal-2">
    <div class="col-lg-4 m-cont">
        <div class="m-header d-flex justify-content-around">
            <h1>You have successfully ordered the products</h1>
        </div>
        <div class="m-body d-flex flex-wrap justify-content-center"><p>Thank you for your recent purchase. We are honored to gain you as a customer and hope to serve you for a long time.</p></div>
        <div class="m-footer  d-flex flex-wrap justify-content-center">
            <button class="btn close" id="close"><a href="index.php">Continue</a></button>
        </div>
    </div>
</div>

