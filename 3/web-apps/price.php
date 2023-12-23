<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Цены</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="main.css">
    <script src="js/telegram-web-apps.js"></script>
    <style>
        body {
            background-color: var(--tg-theme-bg-color);
            color: var(--tg-theme-text-color);
        }

        button {
            background-color: var(--tg-theme-button-color);
            color: var(--tg-theme-button-text-color);
            border: 0;
            padding: 5px 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3 class="text-center">Фото на документы</h3>
        <table class="table table-bordered unborder">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Кол-во</th>
                    <th scope="col">Цветное</th>
                    <th scope="col">Ч/б</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row"> </th>
                    <td>2 шт</td>
                    <td>300 руб.</td>
                    <td>250 руб.</td>
                </tr>
                <tr>
                    <th scope="row"> </th>
                    <td>3 шт</td>
                    <td>350 руб.</td>
                    <td>300 руб.</td>
                </tr>
                <tr>
                    <th scope="row">3x4</th>
                    <td>4 шт</td>
                    <td>400 руб.</td>
                    <td>350 руб.</td>
                </tr>
                <tr>
                    <th scope="row"> </th>
                    <td>5 шт</td>
                    <td>425 руб.</td>
                    <td>375 руб.</td>
                </tr>
                <tr>
                    <th scope="row"> </th>
                    <td>6 шт</td>
                    <td>425 руб.</td>
                    <td>375 руб.</td>
                </tr>
            </tbody>
        </table>
        <p>После 6 штук фото, все последующие фото +25 рублей каждая</p>
        <table class="table table-bordered unborder">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Кол-во</th>
                    <th scope="col">Цветное</th>
                    <th scope="col">Ч/б</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row"></th>
                    <td>2 шт</td>
                    <td>350 руб.</td>
                    <td>300 руб.</td>
                </tr>
                <tr>
                    <th scope="row"> </th>
                    <td>3 шт</td>
                    <td>400 руб.</td>
                    <td>500 руб.</td>
                </tr>
                <tr>
                    <th scope="row">Паспорт, Вод.уд(права), Загран.паспорт</th>
                    <td>4 шт</td>
                    <td>450 руб.</td>
                    <td>400 руб.</td>
                </tr>
                <tr>
                    <th scope="row"> </th>
                    <td>5 шт</td>
                    <td>500 руб.</td>
                    <td>450 руб.</td>
                </tr>
                <tr>
                    <th scope="row"> </th>
                    <td>6 шт</td>
                    <td>550 руб.</td>
                    <td>500 руб.</td>
                </tr>
            </tbody>
        </table>
        <h3 class="text-center">Удостоверение МВД</h3>
        <table class="table table-bordered nth-unborder">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Кол-во</th>
                    <th scope="col">Цветное</th>
                    <th scope="col">Ч/б</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">4x5, 4x6</th>
                    <td>2 шт</td>
                    <td>400 руб.</td>
                    <td>350 руб.</td>
                </tr>
                <tr>
                    <th scope="row" class="bottom_unbord"></th>
                    <td>3 шт</td>
                    <td>425 руб.</td>
                    <td>375 руб.</td>
                </tr>
                <tr>
                    <th scope="row"> </th>
                    <td>4 шт</td>
                    <td>450 руб.</td>
                    <td>400 руб.</td>
                </tr>
                <tr>
                    <th scope="row">6x9</th>
                    <td>2 шт</td>
                    <td>450 руб.</td>
                    <td>400 руб.</td>
                </tr>
                <tr>
                    <th scope="row"> </th>
                    <td>3 шт</td>
                    <td>475 руб.</td>
                    <td>425 руб.</td>
                </tr>

                <tr>
                    <th scope="row"> </th>
                    <td>4 шт</td>
                    <td>500 руб.</td>
                    <td>525 руб.</td>
                </tr>
                <tr>
                    <th scope="row">9x12</th>
                    <td>1 шт</td>
                    <td>250 руб.</td>
                    <td>200 руб.</td>
                </tr>
                <tr>
                    <th scope="row">9x12</th>
                    <td>2 шт</td>
                    <td>300 руб.</td>
                    <td>350 руб.</td>
                </tr>
            </tbody>
        </table>
        <p>Распечатка фото 10x15 -25 руб.</p>
    </div>
    <script>
        const tg = window.Telegram.WebApp;
        tg.ready();
        tg.expand();
    </script>
</body>

</html>