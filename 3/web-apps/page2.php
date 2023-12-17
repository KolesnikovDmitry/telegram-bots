<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../functions.php';



$per_page = 6;
if (isset($_GET['page'])) {
    $page = (int)$_GET['page'];
    if ($page < 1) {
        $page = 1;
    }
    $start = get_start($page, $per_page);
    $products = get_products('products', $start, $per_page);
    $products_frame = get_products('products_frame', $start, $per_page);
    ob_start();
    foreach ($products as $product) {
        require __DIR__ . '/product_tpl.php';
    }
    foreach ($products_frame as $product_frame) {
        require __DIR__ . '/product_frame_tpl.php';
    }
    $html = ob_get_clean();
    echo $html;
    die();
} else {
    $page = 1;
    $start = get_start($page, $per_page);
    $products = get_products('products', $start, $per_page);
    $products_frame = get_products('products_frame', $start, $per_page);
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"">
    <title>Магазин</title>
    <link href=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="main.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="js/telegram-web-apps.js"></script>
</head>

<body>

<div class="container-fluid my-3">
    <div class="row">
        <div class="col-12">

            <nav class="fixed-top">
                <div class="nav nav-tabs animate__animated animate__fadeInDown" id="nav-tab" role="tablist">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#nav-store" type="button" role="tab">Сувениры
                    </button>
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#nav-store-frame" type="button" role="tab">Фоторамки
                    </button>
                    <button class="nav-link mx-auto" data-bs-toggle="tab" data-bs-target="#nav-cart" type="button" role="tab">
                        Корзина<span class="badge rounded-pill bg-danger cart-sum ms-1">0</span>
                    </button>

                </div>
            </nav>

            <div class="tab-content mt-3" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-store" role="tabpanel">
                    <h2 class="animate__animated animate__fadeInDown text-center">Сувениры</h2>
                    <div class="row animate__animated animate__fadeInUp" id="products-list">
                        <?php foreach ($products as $product) : ?>
                            <?php require __DIR__ . '/product_tpl.php'; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="text-center animate__animated animate__fadeInUp" id="loader">
                        <button class="btn btn-warning" id="loader-btn" data-category="store">Показать больше ...</button>
                        <img src="img/loader.svg" alt="" id="loader-img" class="loader-img">
                    </div>
                </div>
                <div class="tab-pane fade " id="nav-store-frame" role="tabpanel">
                    <h2 class="animate__animated animate__fadeInDown text-center">Фоторамки</h2>
                    <div class="row animate__animated animate__fadeInUp" id="products-frame-list">
                        <?php foreach ($products_frame as $product_frame) : ?>
                            <?php require __DIR__ . '/product_frame_tpl.php'; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="text-center animate__animated animate__fadeInUp" id="loader-frame">
                        <button class="btn btn-warning " id="loader-btn-frame" data-category="frame">Показать больше ...</button>
                        <img src="img/loader.svg" alt="" id="loader-img-frame" class="loader-img">
                    </div>
                </div>
                <div class="tab-pane fade show" id="nav-cart" role="tabpanel">
                    <div class="row">
                        <div class="col-12 ">
                            <h2 class="animate__animated animate__fadeInDown text-center">Корзина</h2>

                            <p class="empty-cart text-center">Корзина пуста...</p>

                            <table class="table table-hover animate__animated animate__fadeInUp">
                                <thead>
                                <tr class="text-center">
                                    <th scope="col">#</th>
                                    <th scope="col">Фото</th>
                                    <th scope="col">Название</th>
                                    <th scope="col">Ед.</th>
                                    <th scope="col">Цена</th>
                                    <th scope="col">🗑</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="align-middle">
                                    <th scope="row">1</th>
                                    <td><img src="img/burger.png" class="cart-img" alt=""></td>
                                    <td>Бургер</td>
                                    <td>1</td>
                                    <td>799 руб</td>
                                    <td>
                                        <button class="btn btn-outline-danger del-item">🗑</button>
                                    </td>
                                </tr>
                                <tr class="align-middle">
                                    <th scope="row">2</th>
                                    <td><img src="img/cake.png" class="cart-img" alt=""></td>
                                    <td>Торт</td>
                                    <td>2</td>
                                    <td>1000 руб</td>
                                    <td>
                                        <button class="btn btn-outline-danger del-item">🗑</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<script src="main.js?v=1.09"></script>
</body>

</html>