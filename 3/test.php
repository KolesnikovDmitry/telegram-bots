<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

$cart = [
    1 => [
        'price' => 650,
        'qty' => 1,
    ],
    2 => [
        'price' => 399,
        'qty' => 1,
    ],
    3 => [
        'price' => 500,
        'qty' => 1,
    ],

];
var_dump(check_cart($cart, 1549));

// Предположим, у вас есть массив $groups с информацией о группах товаров
$groups = [
    ['id' => 1, 'name' => 'Группа товаров 1', 'products' => ['product1', 'product2', 'product3']],
    ['id' => 2, 'name' => 'Группа товаров 2', 'products' => ['product4', 'product5', 'product6']],
    // Добавьте другие группы товаров по аналогии
];

// Цикл для генерации модальных окон и слайдеров для каждой группы товаров
foreach ($groups as $group) {
    $groupId = $group['id'];
    $groupName = $group['name'];
    $products = $group['products'];
?>

    <!-- Модальное окно для группы товаров -->
    <div class="modal fade" id="productModalGroup<?= $groupId; ?>" tabindex="-1" aria-labelledby="productModalLabelGroup<?= $groupId; ?>" data-bs-backdrop="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- Слайдер для группы товаров -->
                    <div id="carouselGroup<?= $groupId; ?>" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            // Цикл для генерации слайдов для каждого товара в группе
                            foreach ($products as $index => $product) {
                            ?>
                                <div class="carousel-item<?= $index === 0 ? ' active' : ''; ?>">
                                    <!-- Ваш контент слайда, например, изображение товара -->
                                    <img src="img/<?= $product; ?>.jpg" class="d-block w-100" alt="Slide <?= $index + 1; ?>">
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselGroup<?= $groupId; ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselGroup<?= $groupId; ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>

<?php
}
?>

