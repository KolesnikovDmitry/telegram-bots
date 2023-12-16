<?php

/** @var array $item */ ?>
<div class="col-6 p-2">
    <div class="item-card text-center scale d-flex flex-column justify-content-between h-100">
        <span data-id="<?= $item['id'] ?>" class="item-cart-qty badge rounded-pill bg-warning"></span>
        <img src="img/<?= $item['img'] ?>" class="card-img-top" alt="<?= $item['id']; ?>" data-bs-toggle="modal" data-bs-target="#itemModal<?= $item['id']; ?>">
        <div class="item-card-body ">
            <p class="item-title">
                <?= preg_replace('/("\s*)([^"]+)(\s*")/', "<br>$1$2\n$3", $item['title']);?>
            </p>
            <p class="item-price ">
                <?= $item['price'] / 100 ?> руб.
            </p>
            <span class="qty"> <?= "кол. - " . $item['quantity'] ?> шт.</span>
            <div class="d-grid gap-2 mt-2 ">
                <button class="btn btn-warning add2cart animate__animated" data-item='<?= json_encode($item) ?>'>Добавить
                </button>
            </div>
            <div class="modal fade" id="itemModal<?= $item['id']; ?>" tabindex="-1" aria-labelledby="itemModalLabel<?= $item['id']; ?>" data-bs-backdrop="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div id="carouselStore<?= $item['id'];?>" class="carousel slide " data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active data-bs-interval="10000"">
                                        <img src="img/<?= $item['img'] ?>" class="d-block w-100" >
                                    </div>
                                    <div class="carousel-item data-bs-interval="2000">
                                        <img src="img/<?= $item['img'] ?>" class="d-block w-100" >
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Предыдущий</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
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
