<?php

/** @var array $product_frame */ ?>
<div class="col-6 p-2">
    <div class="product-card text-center scale d-flex flex-column justify-content-between h-100">
        <span data-id="<?= $product_frame['id'] ?>" class="product-cart-qty badge rounded-pill bg-warning">1</span>
        <img src="img/<?= $product_frame['img'] ?>" class="card-img-top" alt="<?= $product_frame['id']; ?>"
             data-bs-toggle="modal" data-bs-target="#productModal<?= $product_frame['id']; ?>">
        <div class="product-card-body ">
            <p class="product-title">
                <?= preg_replace('/("\s*)([^"]+)(\s*")/', "<br>$1$2\n$3", $product_frame['title']); ?>
            </p>
            <p class="product-price ">
                <?= $product_frame['price'] / 100 ?> руб.
            </p>
            <span class="qty"> <?= "кол. - " . $product_frame['quantity'] ?> шт.</span>
            <div class="d-grid gap-2 mt-2 ">
                <button class="btn btn-warning add2cart animate__animated"
                        data-product='<?= json_encode($product_frame) ?>'>Добавить
                </button>
            </div>
            <div class="modal fade" id="productModal<?= $product_frame['id']; ?>" tabindex="-1"
                 aria-labelledby="productModalLabel<?= $product_frame['id']; ?>" data-bs-backdrop="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div id="carouselFrame<?= $product_frame['id']; ?>" class="carousel slide"
                                 data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-product_frame active data-bs-interval=" 10000
                                    "">
                                    <img src="img/<?= $product_frame['img'] ?>" class="d-block w-100">
                                </div>
                                <div class="carousel-product_frame data-bs-interval=" 2000
                                ">
                                <img src="img/<?= $product_frame['img'] ?>" class="d-block w-100">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel"
                                data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Предыдущий</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel"
                                data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Следующий</span>
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>


