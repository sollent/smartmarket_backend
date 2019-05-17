document.body.onload = () => {
    const addToCartButtons = document.querySelectorAll('a.add-to-cart');
    const headerCartButton = document.querySelector('a.cart-big-button');
    const responsiveCartButton = document.getElementById('responsiveCardButton');
    const responsiveProductCount = document.getElementById('responsiveCartProductCount');
    const productCount = document.getElementById('headerCountCartProduct');

    let showCategoriesButton = document.getElementById('showCategoriesBlock');
    let categoriesBlock = document.getElementsByClassName('categories-block')[0];
    let closeCategoriesButton = document.getElementById('close-categories');

    let currentColor;

    let activeLi_first = document.querySelectorAll('.sub-menu > li');

    activeLi_first.forEach((aLi) => {
       aLi.addEventListener('click', () => {
           if (aLi.classList.contains('active')) {
               aLi.classList.add('hover-disable');
               setTimeout(() => {
                   aLi.classList.remove('hover-disable');
               }, 270)
           }
       })
    });

    checkoutCartInfo();

    let productColors = document.querySelectorAll('select#productColors option');
    let currentProductColor = '';
    productColors.forEach(function (productColor) {
        if (productColor.hasAttribute('selected')) {
            currentProductColor = productColor.textContent;
        }
    });

    addToCartButtons.forEach(function (addToCartButton) {

        if (checkCart(addToCartButton))
            checkForExistsProducts(addToCartButton);

        addToCartButton.addEventListener('click', function () {

            if (!checkCart(addToCartButton)) {
                let order = [];
                let orderItem = {
                    productId: addToCartButton.getAttribute('data-product-id'),
                    count: 1,
                    productColor: currentProductColor,
                    price: addToCartButton.getAttribute('data-product-price')
                };
                order.push(orderItem);

                let countInCart = 0;

                if (localStorage.getItem('cartInfo') == null) {
                    localStorage.setItem('cartInfo', JSON.stringify(order));
                    countInCart = 1;
                } else {
                    let currentOrder = JSON.parse(localStorage.getItem('cartInfo'));
                    currentOrder.push(orderItem);
                    localStorage.setItem('cartInfo', JSON.stringify(currentOrder));
                    countInCart = currentOrder.length;
                }

                headerCartButton.classList.add('pulse');
                responsiveCartButton.classList.add('pulse');
                productCount.innerText = countInCart;
                responsiveProductCount.innerText = countInCart;
                M.toast({
                    html: 'Товар добавлен в корзину'
                });

                if (localStorage.getItem('inCart') !== null) {
                    let inCart = JSON.parse(localStorage.getItem('inCart'));
                    inCart.push(addToCartButton.getAttribute('data-product-id'));
                    localStorage.setItem('inCart', JSON.stringify(inCart));
                    checkForExistsProducts(addToCartButton);
                } else {
                    let inCartProducts = [];
                    inCartProducts.push(addToCartButton.getAttribute('data-product-id'));
                    localStorage.setItem('inCart', JSON.stringify(inCartProducts));
                    checkForExistsProducts(addToCartButton);
                }
            }

        })
    });

    showCategoriesButton.addEventListener('click', () => {
        categoriesBlock.classList.remove('not-visible');
        categoriesBlock.classList.add('visible');
        categoriesBlock.classList.add('opacity');
        document.body.style.overflow = "hidden";
    });

    closeCategoriesButton.addEventListener('click', () => {
       categoriesBlock.classList.remove('visible');
       categoriesBlock.classList.add('not-visible');
       categoriesBlock.classList.remove('opacity');
       document.body.style.overflow = "auto";
    });

    function checkForExistsProducts(addToCartButton) {
        // Check exists products in cart
        if (localStorage.getItem('inCart') !== null) {
            let products = JSON.parse(localStorage.getItem('inCart'));
            if (products.find(p => +p === +addToCartButton.getAttribute('data-product-id'))) {
                addToCartButton.classList.remove('add-to-cart');
                addToCartButton.classList.add('now-go-to-cart');
                addToCartButton.innerHTML = '<i class="material-icons right">shopping_cart</i>Перейти в корзину';
                setTimeout(() => {
                    addToCartButton.href = headerCartButton.href;
                }, 100);
                let header = document.getElementsByClassName('header-nav')[0];
                if (!header.classList.contains('active')) {
                    header.classList.add('active');
                }
            }
        }
    }

    function checkCart(addToCartButton) {
        if (localStorage.getItem('inCart') !== null) {
            let products = JSON.parse(localStorage.getItem('inCart'));
            if (products.find(p => +p === +addToCartButton.getAttribute('data-product-id'))) {
                return true;
            }
        }

        return false;
    }

    function checkoutCartInfo() {
        if (localStorage.getItem('cartInfo') !== null) {
            headerCartButton.classList.add('pulse');
            responsiveCartButton.classList.add('pulse');
            productCount.innerText = JSON.parse(localStorage.getItem('cartInfo')).length;
            responsiveProductCount.innerText = JSON.parse(localStorage.getItem('cartInfo')).length;
        }
    }

};

