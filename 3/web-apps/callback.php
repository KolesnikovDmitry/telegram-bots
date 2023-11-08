<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="telegram-web-apps.js"></script>
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
        .error {
            border-color: #d260aa;
        }

        .error-message {
            color: #d260aa;
            margin-bottom: 1em;
        }
    </style>
</head>
<body>
<div class="container">

    <h3>Подписаться</h3>
    <form class="row g-3 needs-validation px-3" id="form" novalidate>
        <div class="col-md-6">
            <label for="name" class="form-label">Имя</label>
            <input type="text" class="form-control" id="name" pattern="^[a-zA-Zа-яА-ЯёЁ_\-\s']{2,48}$" data-bouncer-message="Разрешены буквы, дефис и символ подчеркивания" required>
        </div>
        <div class="col-md-6">
            <label for="number" class="form-label">Номер телефона</label>
            <input type="tel" class="form-control" name="phone" id="phone" placeholder="+7(000)000-00-00" required />
        </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const tg = window.Telegram.WebApp;
    // console.log(tg);
    tg.ready();
    tg.expand();

    // const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const nameInput = document.getElementById('name');

    const data = {name: "", phone: ""};

    tg.onEvent('mainButtonClicked', () => {
        tg.sendData(JSON.stringify(data));
    });

    nameInput.addEventListener("input", () => {
        let val = nameInput.value.trim();
        const re = /^[a-zA-Zа-яА-ЯёЁ_\-\s']{2,48}$/;

        if (re.test(val)) {
            data.name = val;
            toggleClass(nameInput, 'is-valid', 'is-invalid');
        } else {
            data.name = '';
            toggleClass(nameInput, 'is-invalid', 'is-valid');
        }
        checkForm();
    });

    function checkForm() {
        if (!data.name || !data.phone ) {
            tg.MainButton.hide();
        } else {
            tg.MainButton.setParams({
                text: "Заказать звонок",
                color: '#d260aa',
                text_color: '#fff'
            });
            tg.MainButton.show();
        }
    }

    function toggleClass(field, class_add, class_remove) {
        field.classList.add(class_add);
        field.classList.remove(class_remove);
    }

</script>
<script src="https://unpkg.com/imask"></script>
<script>
    let element = document.getElementById('phone');
    let maskOptions = {
        mask: '+7(000)000-00-00',
        lazy: false
    }
    let mask = new IMask(element, maskOptions);
</script>
<script>
    phoneInput.addEventListener("input", () => {
        let val = phoneInput.value.trim();

        const re = /^\+?\d{1,4}?[-.\s]?\(?\d{3}\)?[-.\s]?\d{3}[-.\s]?\d{2}[-.\s]?\d{2}$/;
        if (re.test(val)) {
            data.phone = val;
            toggleClass(phoneInput, 'is-valid', 'is-invalid');
        } else {
            data.phone = '';
            toggleClass(phoneInput, 'is-invalid', 'is-valid');
        }
        checkForm();
    });

</script>
<script src="../js/bouncer.polyfills.min.js"></script>
<script>
    const validate = new Bouncer('#form', {
        messages: {
            missingValue: {
                default: 'Пожалуйста, заполните это поле',

            });
</script>
</body>
</html>

