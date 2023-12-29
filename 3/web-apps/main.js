const tg = window.Telegram.WebApp;
tg.ready();
tg.expand();
const productsContainer = document.getElementById('product-list');
const productsFrameContainer = document.getElementById('product-frame-list');
const loaderBtn = document.getElementById('loader-btn');
const loaderBtnFrame = document.getElementById('loader-btn-frame');
const loaderImg = document.getElementById('loader-img');
const loaderImgFrame = document.getElementById('loader-img-frame');
const cartTable = document.querySelector('table');
let page = 1;

async function getProducts() {
    const res = await fetch(`page2.php?page=${encodeURIComponent(page)}&category=${encodeURIComponent(category)}`);
    return res.text();
}

// async function showProducts() {
//     const products = await getProducts();
//     if (products) {
//         if (category === 'store') {
//             productsContainer.insertAdjacentHTML('beforeend', products);
//         } else if (category === 'frame') {
//             productsFrameContainer.insertAdjacentHTML('beforeend', products);
//         }
//     } else {
//         loaderBtn.classList.add('d-none');
//         loaderBtnFrame.classList.add('d-none');
//         const messageContainer = category === 'store' ? productsContainer : productsFrameContainer;
//         messageContainer.insertAdjacentHTML('beforeend', "<p class='scale'>Извините, товаров больше нет.</p>");
//         messageContainer.classList.add('no-products-message');
//     }
// }
//
// async function showProductsFrame() {
//     const products_frame = await getProducts();
//     if (products_frame) {
//         productsFrameContainer.insertAdjacentHTML('beforeend', products_frame);
//     } else {
//         loaderBtnFrame.classList.add('d-none');
//         productsFrameContainer.insertAdjacentHTML('beforeend', "<p class='scale'>Извините, товаров больше нет.</p>");
//         productsFrameContainer.classList.add('no-products-message');
//     }
// }
async function showProducts(category) {
    const products = await getProducts();
    const container = category === 'store' ? productsContainer : productsFrameContainer;

    if (products) {
        container.insertAdjacentHTML('beforeend', products);
    } else {
        loaderBtn.classList.add('d-none');
        loaderBtnFrame.classList.add('d-none');
        container.insertAdjacentHTML('beforeend', "<p class='scale'>Извините, товаров больше нет.</p>");
        container.classList.add('no-products-message');
    }
}

// Общий обработчик для всех кнопок
document.addEventListener('click', (e) => {
    // const loaderBtn = e.target.closest('#loader-btn');
    // const loaderBtnFrame = e.target.closest('#loader-btn-frame');
    const loaderBtn = e.target.closest('[data-category]');

    // if (loaderBtn) {
    //     handleLoaderButtonClick('store');
    // } else if (loaderBtnFrame) {
    //     handleLoaderButtonClick('frame');
    // }

    if (loaderBtn) {
        category = loaderBtn.dataset.category;
        handleLoaderButtonClick(category);
        console.log(`Clicked on loader-btn for ${category}`);
    }
});

// function handleLoaderButtonClick(category) {
//     console.log('Clicked "Показать больше" for category:', category);
//     loaderImg.classList.add('d-inline-block');
//     loaderImgFrame.classList.add('d-inline-block');
//     setTimeout(() => {
//         page++;
//
//         if (category === 'store') {
//             showProducts().then(() => productQty(cart));
//         } else if (category === 'frame') {
//             showProductsFrame().then(() => productQty(cart));
//         }
//
//         loaderImg.classList.remove('d-inline-block');
//         loaderImgFrame.classList.remove('d-inline-block');
//     }, 1000);
// }
function handleLoaderButtonClick(category) {
    console.log('Clicked "Показать больше" for category:', category);
    loaderImg.classList.add('d-inline-block');
    loaderImgFrame.classList.add('d-inline-block');
    setTimeout(() => {
        page++;

        if (category === 'store') {
            showProducts('store').then(() => productQty(cart));
        } else if (category === 'frame') {
            showProducts('frame').then(() => productQty(cart));
        }

        loaderImg.classList.remove('d-inline-block');
        loaderImgFrame.classList.remove('d-inline-block');
    }, 1000);
}



function getCart(setCart = false) {
    if (setCart) {
        localStorage.setItem('cart', JSON.stringify(setCart));
    }
    return localStorage.getItem('cart') ? JSON.parse(localStorage.getItem('cart')) : {};
}

function add2Cart(product) {
    let id = product.id;
    if (id in cart) {
        console.log(cart[id]['qty'], id);
        cart[id]['qty'] += 1;
    } else {
        cart[id] = product;
        cart[id]['qty'] = 1;
    }
    getCart(cart);
    getCartSum(cart);
    productQty(cart);
    cartContent(cart);
}

function getCartSum(items) {
    let cartSum = Object.entries(items).reduce(function (total, values) {
        const [key, value] = values;
        return total + (value['qty'] * value['price']);
    }, 0);
    document.querySelector('.cart-sum').innerText = cartSum / 100 + 'руб';
    return cartSum;
}

function productQty(items) {
    document.querySelectorAll('.product-cart-qty').forEach(item => {
        let id = item.dataset.id;
        if (id in items) {
            item.innerText = items[id]['qty'];
        } else {
            item.innerText = '';
        }
    })
}

function cartContent(items) {
    let cartTableBody = document.querySelector('.table tbody');
    let cartEmpty = document.querySelector('.empty-cart');
    let qty = Object.keys(items).length;
    if (qty) {
        tg.MainButton.show();
        tg.MainButton.setParams({
            text: `Купить: ${getCartSum(items) / 100} руб.`,
            color: '#d7b300'
        });
        cartTable.classList.remove('d-none');
        cartEmpty.classList.remove('d-block');
        cartEmpty.classList.add('d-none');
        cartTableBody.innerHTML = '';
        Object.keys(items).forEach(key => {
            let formattedTitle = items[key]['title'].replace('/("\s*)([^"]+)(\s*")/', "<br>$1$2\n$3n$4");
            cartTableBody.innerHTML += `
<tr class="align-middle animate__animated">
    <th scope="row">${key}</th>
    <td><img src="img/${items[key]['img']}" class="cart-img" alt=""></td>
     <td>${formattedTitle}</td>
    <td>${items[key]['qty']}</td>
    <td>${items[key]['price'] / 100}р.</td>
    <td data-id="${key}"><button class="btn del-item">🗑</button></td>
</tr>
`;
        });
    } else {
        tg.MainButton.hide();
        cartTableBody.innerHTML = '';
        cartTable.classList.add('d-none');
        cartEmpty.classList.remove('d-none');
        cartEmpty.classList.add('d-block');
    }
}

let cart = getCart();
getCartSum(cart);
productQty(cart);
cartContent(cart);

// Add listener for add product
// Обработчик для контейнера с продуктами
productsContainer.addEventListener('click', handleAddToCart);

// Обработчик для контейнера с фоторамками
productsFrameContainer.addEventListener('click', handleAddToCart);

function handleAddToCart(e) {
    console.log('Add to cart button clicked');
    if (e.target.classList.contains('add2cart')) {
        e.preventDefault();
        e.target.classList.add('animate__flipInX');
        add2Cart(JSON.parse(e.target.dataset.product));
        setTimeout(() => {
            e.target.classList.remove('animate__flipInX');
        }, 1000);
    }
}



// Add listener for delete product
cartTable.addEventListener('click', (e) => {
    const target = e.target.closest('.del-item');
    if (target) {
        let id = target.parentElement.dataset.id;
        target.parentElement.parentElement.classList.add('animate__zoomOut');
        setTimeout(() => {
            delete cart[id];
            getCart(cart);
            getCartSum(cart);
            productQty(cart);
            cartContent(cart);
        }, 300);
    }

});

tg.MainButton.onClick(() => {
    // alert(tg.initDataUnsafe.query_id);
    // console.log(tg);
    fetch('../index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify({
            query_id: tg.initDataUnsafe.query_id,
            user: tg.initDataUnsafe.user,
            cart: cart,
            total_sum: getCartSum(cart)
        })
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.res) {
                cart = getCart({});
                getCartSum(cart);
                productQty(cart);
                cartContent(cart);
                tg.close();
            } else {
                alert(data.answer);
            }
        });
});