let cartTabs = document.getElementsByClassName('modal-content')[0],
    nextStep = document.getElementById('nextStep'),
    prevStep = document.getElementById('prevStep'),
    firstStepLink = document.getElementById('firstStepLink'),
    firstStepBlock = document.getElementById('firstStep'),
    secondStepLink = document.getElementById('secondStepLink'),
    thirdStepLink = document.getElementById('thirdStepLink'),
    thirdStepBlock = document.getElementById('thirdStep'),
    nextButton,
    secondNextButton = document.getElementById('secondNextButton'),
    thirdNextButton = document.getElementById('thirdNextButton'),
    activeLink,
    minskTabLink = document.getElementById('tabMinsk'),
    mailTabLink = document.getElementById('tabMail'),
    deleteProductsButtons_large = document.getElementsByClassName('delete-product'),
    deleteProductsButtons_small = document.getElementsByClassName('delete-product-small'),
    productSectionBlocks = document.getElementsByClassName('product-section'),
    bonusBlock = document.getElementById('bonus-section'),
    cartTotalSum = document.getElementById('cart-total-sum'),
    cartFooterTabs = document.getElementsByClassName('footer-cart-tabs')[0],
    links = [
        {id: 1, value: firstStepLink},
        {id: 2, value: secondStepLink},
        {id: 3, value: thirdStepLink}
    ],
    // steps = {
    //     'stepOne': 'Шаг 1: Ваша корзина',
    //     'stepTwo': 'Шаг 2: Доставка и выбор оплаты',
    //     'stepThree': 'Шаг 3: Дополнительная информация'
    // }
    steps = [
        {
            name: 'stepOne',
            short: 'Ваша корзина',
            iconClass: 'shopping_cart',
            description: 'Шаг 1: Проверьте заказы в вашей корзине'
        },
        {
            name: 'stepTwo',
            short: 'Оформление заказа',
            iconClass: 'border_color',
            description: 'Шаг 2: Заполните информацию для заказа'
        },
        {
            name: 'stepThree',
            short: 'Проверка заказа',
            iconClass: 'check_box',
            description: 'Шаг 3: Проверьте ваш заказ'
        }
    ],
    clientNameInput = document.getElementById('clientNameInput'),
    clientPhoneInput = document.getElementById('clientPhoneInput'),
    deliveryWayCheckboxes = document.getElementsByClassName('delivery-way-checkbox'),
    clientAddressInput = document.getElementById('clientAddressInput'),
    clientDeliveryTimeInput = document.getElementById('clientDeliveryTimeInput'),
    clientDeliveryDateInput = document.getElementById('clientDeliveryDateInput'),
    clientFullName = document.getElementById('clientFullNameInput_mail'),
    clientCityInput = document.getElementById('clientCityInput'),
    clientStreetInput = document.getElementById('clientStreetInput'),
    clientPhoneInput_mail = document.getElementById('clientPhoneInput_mail'),
    mailIndex = document.getElementById('mailIndex'),
    homeInfo = document.getElementById('homeInfo'),
    apartmentNumber = document.getElementById('apartmentNumber'),
    mail_deliveryWayCheckboxes = document.querySelectorAll('#delivery-mail-ways label input.delivery-way-checkbox'),
    homeInfoMinsk = document.getElementById('homeInfoMinsk'),
    apartmentNumberMinsk = document.getElementById('apartmentNumberMinsk'),
    cartLoader = document.getElementById('cart-loader'),
    loaderBlock = document.getElementById('loader-block'),
    cartFooter = document.getElementsByClassName('cart-footer')[0],
    successBlock = document.getElementsByClassName('success-block')[0],
    siteFooter = document.getElementById('site-footer'),
    clientTodayInput = document.getElementById('clientTodayInput'),
    clientOtherDateInput = document.getElementById('clientOtherDateInput'),
    scrollToTop = document.getElementById('scroll-to-top-success'),
    checkOrder = document.getElementById('checkOrder'),
    promocodeBlock = document.getElementsByClassName('promocode-response')[0],
    promoCode, promoCodeValue,
    recalculateButton,
    removeProductButton,
    addProductButton,
    emailForPromoInput = document.getElementById('emailForPromo')

;

let mainCartIcon = document.getElementById('modal-main-icon');
let mainCartCaption = document.getElementById('modal-main-caption');
let modalHeader = document.getElementById('cartModalHeader');
let stepInfoElement = document.createElement('h6');
stepInfoElement.className = 'step-info';
replaceStepInfo('stepOne');

let tabMinsk = document.getElementById('tabMinsk');

document.body.onload = () => {

    loaderBlock.innerHTML = '<div class="loader" id="cart-loader"></div>';

    secondNextButton.addEventListener('click', () => {
       nextStep.click();
    });

    thirdNextButton.addEventListener('click', () => {
       nextStep.click();
    });

    // Define datepicker
    let datepickerOptions =
        {
            i18n: {
                cancel: 'Отмена',
                done: 'ОК',
                months:
                    [
                        'Январь',
                        'Февраль',
                        'Март',
                        'Апрель',
                        'Май',
                        'Июнь',
                        'Июль',
                        'Август',
                        'Сентябрь',
                        'Октябрь',
                        'Ноябрь',
                        'Декабрь'
                    ],
                monthsShort:
                    [
                        'Янв',
                        'Фев',
                        'Мар',
                        'Апр',
                        'Май',
                        'Июн',
                        'Июл',
                        'Авг',
                        'Сен',
                        'Окт',
                        'Ноя',
                        'Дек'
                    ],
                weekdays:
                    [
                        'Воскресенье',
                        'Понедельник',
                        'Вторник',
                        'Среда',
                        'Четверг',
                        'Пятница',
                        'Суббота'
                    ],
                weekdaysShort:
                    [
                        'Вс',
                        'Пн',
                        'Вт',
                        'Ср',
                        'Чт',
                        'Пт',
                        'Сб'
                    ],
                weekdaysAbbrev:
                    [
                        'Вс',
                        'Пн',
                        'Вт',
                        'Ср',
                        'Чт',
                        'Пт',
                        'Сб'
                    ]
            },
            format: 'dd.mm.yyyy'
        };
    let datepicker = document.querySelectorAll('.datepicker');
    M.Datepicker.init(datepicker, datepickerOptions);

    siteFooter.classList.add('dn');

    let CURRENT_CITY_ID = 0;

    // Block next step if cart is empty
    if (localStorage.getItem('cartInfo') === null) {
        nextStep.classList.add('disabled');
        nextStep.parentElement.style.pointerEvents = "none";
        let iconRight = document.getElementsByClassName('cart-icon-right')[0];
        iconRight.style.color = "#b2b2b2";
    }

    mailTabLink.addEventListener('click', () => {
        if (nextStep.parentElement.classList.contains('dn')) {
            nextStep.parentElement.classList.remove('dn');
        }
        if (document.getElementById('close-validation-cart-message') !== undefined) {
            document.getElementById('close-validation-cart-message').parentNode.parentNode.removeChild(
                document.getElementById('close-validation-cart-message').parentNode
            );
        }
    });

    minskTabLink.addEventListener('click', () => {
        if (deliveryWayCheckboxes[1].checked && !nextStep.parentElement.classList.contains('dn')) {
            nextStep.parentElement.classList.add('dn');
        }
        if (document.getElementById('close-validation-cart-message') !== undefined) {
            document.getElementById('close-validation-cart-message').parentNode.parentNode.removeChild(
                document.getElementById('close-validation-cart-message').parentNode
            );
        }
    });

    const headerCartButton = document.querySelector('a.cart-big-button');
    const productCount = document.getElementById('headerCountCartProduct');

    checkoutCartInfo();

    // // Preloader showing
    // let preloader = document.getElementById('site-preloader');
    // if (!preloader.classList.contains('done')) {
    //     preloader.classList.add('done');
    // }
    // Cart steps working
    for (let i = 0; i < links.length; i++) {
        if (links[i]['value'].classList.contains('active')) {
            activeLink = links[i];
        }
    }

    prevStep.onclick = () => {
        switch (activeLink.id) {
            case 3:
                secondStepLink.click();
                tabMinsk.click();
                activeLink = links.find(l => l.id === 2);
                replaceStepInfo('stepTwo');
                nextStep.innerText = 'Продолжить';
                nextStep.parentElement.classList.remove('dn');
                prevStep.parentElement.classList.remove('set-full-width');
                cartFooterTabs.classList.remove('more-width');
                break;
            case 2:
                firstStepLink.click();
                activeLink = links.find(l => l.id === 1);
                replaceStepInfo('stepOne');
                nextStep.innerText = 'Продолжить';
                break;
        }
    };

    nextStep.onclick = () => {
        switch (activeLink.id) {
            case 3:
                cartTabs.parentNode.removeChild(cartTabs);
                cartFooter.parentNode.removeChild(cartFooter);
                loaderBlock.innerHTML = '<div class="loader" id="cart-loader"></div>';
                sendResultData();
                // Order logic
                break;
            case 2:
                if (minskTabLink.classList.contains('active')) {
                    if (saveMinskOrderInfo()) {
                        if (document.getElementsByClassName('validation-cart-message')[0] !== undefined) {
                            document.getElementById('close-validation-cart-message').click();
                        }
                        thirdStepLink.parentElement.classList.remove('disabled');
                        thirdStepLink.click();
                        activeLink = links.find(l => l.id === 3);
                        replaceStepInfo('stepThree');
                        nextStep.innerText = 'Оформить';
                        scrollToTop.click();
                        showOrderDetails();
                        showOrderedProducts();
                        retransformButtons();
                        // check order information
                        // checkOrderInfo();s
                        // save order info into local storage
                    }
                } else {
                    if (saveMailOrderInfo()) {
                        if (document.getElementsByClassName('validation-cart-message')[0] !== undefined) {
                            document.getElementById('close-validation-cart-message').click();
                        }
                        thirdStepLink.parentElement.classList.remove('disabled');
                        thirdStepLink.click();
                        activeLink = links.find(l => l.id === 3);
                        replaceStepInfo('stepThree');
                        nextStep.innerText = 'Оформить';
                        scrollToTop.click();
                        showOrderDetails();
                        showOrderedProducts();
                        retransformButtons();
                        // check order information
                        // checkOrderInfo();
                        // save order info into local storage
                    }
                }
                // renderOrderInfoOnThirdStep(JSON.parse(localStorage.getItem('deliveryInfo')));
                break;
            case 1:
                secondStepLink.parentElement.classList.remove('disabled');
                secondStepLink.click();
                tabMinsk.click();
                activeLink = links.find(l => l.id === 2);
                prevStep.parentElement.classList.remove('hide');
                scrollToTop.click();
                replaceStepInfo('stepTwo');
                break;
        }
    };

    function retransformButtons() {
        nextStep.parentElement.classList.add('dn');
        prevStep.parentElement.classList.add('set-full-width');
        cartFooterTabs.classList.add('more-width');
    }

    function showOrderDetails() {
        let details = prepareArrayDetails();
        let orderDate = '', deliveryWay = '', mailIndexHtml = '', deliveryDateAndTimeHtml = '', deliveryTimeHtml = '';
        if (details.type === 'Minsk') {
            orderDate = details.deliveryDate === 'today' ? 'Сегодня' : details.deliveryDate;
            deliveryWay = details.deliveryWay === 'driver' ? 'Курьером' : 'Самовывоз';
            deliveryTimeHtml = '<td>Желаемое время доставки</td><td class="second-td">' + details.deliveryTime + '</td>';
            deliveryDateAndTimeHtml = '<tr><td>Способ доставки</td><td class="second-td">' + deliveryWay + '</td></tr><tr><td>Дата доставки</td><td class="second-td">' + orderDate + '</td></tr>';
        } else {
            mailIndexHtml = '</tr><tr><td>Почтовый индекс</td><td class="second-td">' + details.mailIndex + '</td></tr>';
        }
        let orderDetails = '<h3>Проверьте свой заказ</h3><div class="check-order-info"><div class="row"><div class="col l6 s12"><table class="check-order-table"><tbody><tr><td>Ваше имя</td><td class="second-td">' + details.name + '</td></tr><tr><td>Номер телефона</td><td class="second-td">' + details.phone + '</td></tr><tr><td>Адресс</td><td class="second-td">' + details.address + '</td>' + mailIndexHtml + '</tbody></table></div><div class="col l6 s12"><table class="check-order-table"><tbody>' + deliveryDateAndTimeHtml + '<tr>' + deliveryTimeHtml + '</tr><tr><td>Уведомления</td><td class="second-td">По SMS</td></tr></tbody></table></div></div></div>';
        checkOrder.innerHTML = orderDetails;
    }

    function showOrderedProducts() {
        let products = JSON.parse(localStorage.getItem('cartInfo'));
        let items = '';
        products.forEach((p) => {
            items += '<li>' + p.name + ', ' + p.count + ' шт.</li>';
        });
        let orderedHTML = '<h5>В заказе:</h5><div class="ordered-products"><ul>' + items + '</ul></div><div class="ordered-sum">На сумму:<span> ' + JSON.parse(localStorage.getItem('totalSum')) + ' BYN</span></div>';
        let orderedBlock = document.getElementsByClassName('ordered-products-and-sum')[0];
        orderedBlock.innerHTML = orderedHTML;
    }

    function prepareArrayDetails() {
        let details = JSON.parse(localStorage.getItem('deliveryInfo'));
        let resultDetails = {};
        resultDetails = details;
        if (details.type === 'Minsk') {
            // Form array for Minsk
            resultDetails.address =  'г.Минск, ' + details.address + ', дом. ' + details.homeInfo + ', кв. ' + details.apartmentNumber;
            delete resultDetails.homeInfo;
            delete resultDetails.apartmentNumber;

        } else {
            // Form array for Mail
            resultDetails.address = 'г.' + details.city + ', ' + details.street + ', дом. ' + details.homeInfo + ', кв. ' + details.apartmentNumber;
            delete resultDetails.city;
            delete resultDetails.street;
            delete resultDetails.homeInfo;
            delete resultDetails.apartmentNumber;
            resultDetails.name = resultDetails.fullName;
            delete resultDetails.fullName;
        }

        return resultDetails;
    }


    // AJAX request to get products
    if (localStorage.getItem('cartInfo') !== null) {
        let ajax = new XMLHttpRequest();
        ajax.open('POST', '/api/order/get-products', true);

        let ids = [];

        JSON.parse(localStorage.getItem('cartInfo')).forEach((orderInfo) => {
            ids.push(orderInfo.productId);
        });

        let formData = new FormData();
        formData.append('ids', JSON.stringify(ids));

        ajax.send(formData);

        ajax.onreadystatechange = () => {
            if (ajax.status === 200 && ajax.readyState === 4) {
                let orderedProducts = JSON.parse(ajax.responseText);
                let spinner = document.getElementById('cart-loader');
                spinner.parentNode.removeChild(spinner);
                renderOrderedProducts(orderedProducts);
                let products = JSON.parse(localStorage.getItem('cartInfo'));
                orderedProducts.forEach((p) => {
                    products.find(prod => +prod.productId === +p.id)['name'] = p.name;
                });
                localStorage.setItem('cartInfo', JSON.stringify(products));
                cartTotalSum = document.getElementById('cart-total-sum');
                console.log(deleteProductsButtons_large);
            }
        };
    } else {
        firstStepBlock.innerHTML = "<h6 class='center-align'>Ваша корзина пуста</h6>";
    }

    // getError function returned html span
    function getErrorHtmlSpan(message) {
        return "<span id='error-message' class='helper-text invalid-color'>" + message + "</span>";
    }

    // MINSK ORDER
    //
    // let MinskErrorStack = {
    //     name: true,
    //     phone: true,
    //     address: true,
    //     deliveryWay: true,
    //     deliveryTime: true
    // };

    // Read order date values

    clientTodayInput.addEventListener('click', () => {
        if (!clientTodayInput.checked) {
            clientTodayInput.checked = true;
        } else {
            clientOtherDateInput.checked = false;
            clientDeliveryDateInput.value = null;
            console.log(clientDeliveryDateInput.value);
        }
    });

    clientOtherDateInput.addEventListener('click', () => {
        if (clientOtherDateInput.checked && clientTodayInput.checked) {
            clientTodayInput.checked = false;
        }
        clientDeliveryDateInput.click();
        let datepickerCancel = document.getElementsByClassName('datepicker-cancel')[0];
        console.log(datepickerCancel);
        datepickerCancel.addEventListener('click', () => {
            console.log('csacas');
            if (clientOtherDateInput.checked) {
                clientOtherDateInput.checked = false;
                clientTodayInput.checked = true;
            }
        });
    });

    // Read inputs values (name, phone, address)
    let clientNameValue, clientPhoneValue, clientAddressValue;
    clientNameInput.addEventListener('input', () => {
        clientNameValue = clientNameInput.value;
    });
    clientNameInput.addEventListener('blur', () => {
        if (!isName(clientNameValue)) {
            console.log(false);
        } else {
            console.log(true);
        }
    });
    clientPhoneInput.addEventListener('input', () => {
        clientPhoneValue = clientPhoneInput.value;
    });
    clientPhoneInput.addEventListener('blur', () => {
        let spanError = document.getElementById('error-message');
        if (!isPhoneNumber(clientPhoneValue)) {
            if (spanError) {
                spanError.parentNode.removeChild(spanError);
            }
            clientPhoneInput.classList.add('invalid');
            clientPhoneInput.parentElement.insertAdjacentHTML('beforeend', getErrorHtmlSpan(
                "Введите правильный номер телефона"
            ));
        } else {
            spanError.parentNode.removeChild(spanError);
            clientPhoneInput.classList.remove('invalid');
        }
    });
    clientAddressInput.addEventListener('input', () => {
        clientAddressValue = clientAddressInput.value;
        findMinskStreets(clientAddressInput.value);
    });

    function findMinskStreets(char) {
        const MINSK_ID = 15316;

        let findStreets = new XMLHttpRequest();
        findStreets.open('GET', 'https://superresheba.by/market/default/search-street?city_id=' + MINSK_ID + '&word=' + char, true);

        findStreets.send();

        findStreets.onreadystatechange = () => {
            if (findStreets.status === 200 && findStreets.readyState === 4) {
                let data = JSON.parse(findStreets.responseText);
                let options = {
                    data: {},
                    limit: 10
                };
                for (let i = 0; i < data.length; i++) {
                    options.data[data[i].name] = null;
                }
                M.Autocomplete.init(clientAddressInput, options);
            }
        };

    }

    // Read on the third step
    let emailForPromoValue = '';
    emailForPromoInput.addEventListener('input', () => {
        emailForPromoValue = emailForPromoInput.value;
    });

    // validation functions
    function isPhoneNumber(phone) {
        if (phone.length >= 7 && phone.length <= 17 &&
            (phone.substring(0, 4) === '+375' ||
                phone.substring(0, 2) === '80')
        ) {
            return true;
        }

        return false;
    }

    function isName(name) {
        if (name.length < 2 || name.length > 45) {
            return false;
        }
        return true;
    }

    // Read checkboxes (delivery way)
    let deliiveryWayValue = "";
    deliveryWayCheckboxes[0].checked = true;
    deliveryWayCheckboxes[1].checked = false;
    // Driver
    deliveryWayCheckboxes[0].addEventListener('click', () => {
        if (deliveryWayCheckboxes[0].checked) {
            deliveryWayCheckboxes[1].checked = false;
            if (
                document
                    .getElementsByClassName('delivery-driver-info')[0]
                    .classList
                    .contains('dn')
            ) {
                document
                    .getElementsByClassName('delivery-driver-info')[0]
                    .classList
                    .remove('dn');
            }
            if (
                document.getElementsByClassName('input-client-date')[0]
                    .classList
                    .contains('dn')
            ) {
                document.getElementsByClassName('input-client-date')[0]
                    .classList
                    .remove('dn')
            }
            if (
                document
                    .getElementById('delivery-address-block')
                    .classList
                    .contains('dn')
            ) {
                document
                    .getElementById('delivery-address-block')
                    .classList
                    .remove('dn');
            }
            if (
                !document
                    .getElementsByClassName('delivery-own-info')[0]
                    .classList
                    .contains('dn')
            ) {
                document.getElementsByClassName('delivery-own-info ')[0].classList.add('dn');
            }
            if (nextStep.parentElement.classList.contains('dn')) {
                nextStep.parentElement.classList.remove('dn');
            }
            if (document.getElementsByClassName('delivery-time')[0].classList.contains('dn')) {
                document.getElementsByClassName('delivery-time')[0].classList.remove('dn');
            }
            if (secondNextButton.classList.contains('dn')) {
                secondNextButton.classList.remove('dn');
            }
        } else {
            deliveryWayCheckboxes[0].checked = true;
        }
    });
    // Own
    deliveryWayCheckboxes[1].addEventListener('click', () => {
        if (deliveryWayCheckboxes[1].checked) {
            deliveryWayCheckboxes[0].checked = false;
            if (
                !document
                    .getElementsByClassName('delivery-driver-info')[0]
                    .classList
                    .contains('dn')
            ) {
                document
                    .getElementsByClassName('delivery-driver-info')[0]
                    .classList
                    .add('dn');
                document
                    .getElementById('delivery-address-block')
                    .classList
                    .add('dn')
            }
            if (
                document
                    .getElementsByClassName('delivery-own-info')[0]
                    .classList
                    .contains('dn')
            ) {
                document
                    .getElementsByClassName('delivery-own-info ')[0]
                    .classList
                    .remove('dn')
            }
            if (
                !document.getElementsByClassName('input-client-date')[0]
                    .classList
                    .contains('dn')
            ) {
                document.getElementsByClassName('input-client-date')[0]
                    .classList
                    .add('dn')
            }
            if (!secondNextButton.classList.contains('dn')) {
                secondNextButton.classList.add('dn');
            }
            nextStep.parentElement.classList.add('dn');
            document.getElementsByClassName('delivery-time')[0].classList.add('dn');
        } else {
            deliveryWayCheckboxes[1].checked = true;
        }
    });

    // Delivery date
    let clientDeliveryTimeValue = '';
    clientDeliveryTimeInput.addEventListener('input', () => {
        clientDeliveryTimeValue = clientDeliveryTimeInput.value;
    });

    let homeInfoMinskValue, apartmentNumberMinskValue;

    homeInfoMinsk.addEventListener('input', () => {
        homeInfoMinskValue = homeInfoMinsk.value;
    });

    apartmentNumberMinsk.addEventListener('input', () => {
        apartmentNumberMinskValue = apartmentNumberMinsk.value;
    });

    // MAIL ORDER

    // Read all inputs values
    let clientFullNameValue, clientCityValue, clientStreetValue,
        clientPhone_mailValue, mailIndexValue, homeInfoValue, apartmentNumberValue;

    clientFullName.addEventListener('input', () => {
        clientFullNameValue = clientFullName.value;
    });

    clientCityInput.addEventListener('input', () => {
        clientCityValue = clientCityInput.value;
        findCities(clientCityInput.value);
    });

    clientCityInput.addEventListener('blur', () => {
        setCityId();
    });

    function setCityId() {
        let getCityId = new XMLHttpRequest();
        getCityId.open('GET', 'https://superresheba.by/market/default/search-city?word=' + clientCityInput.value, true);

        getCityId.send();

        getCityId.onreadystatechange = () => {
            if (getCityId.status === 200 && getCityId.readyState === 4) {
                let data = JSON.parse(getCityId.responseText);
                for (let i = 0; i < data.length; i++) {
                    if (clientCityInput.value === data[i].name) {
                        CURRENT_CITY_ID = data[i].id;
                    }
                }
            }
        }
    }

    function findCities(char) {
        let findCities = new XMLHttpRequest();
        findCities.open('GET', 'https://superresheba.by/market/default/search-city?word=' + char, true);

        findCities.send();

        findCities.onreadystatechange = () => {
            if (findCities.status === 200 && findCities.readyState === 4) {
                let data = JSON.parse(findCities.responseText);
                console.log(data);
                let options = {
                    data: {},
                    limit: 10
                };
                for (let i = 0; i < data.length; i++) {
                    options.data[data[i].name] = null;
                }
                M.Autocomplete.init(clientCityInput, options);
            }
        };
        // let options = {
        //     data: {
        //         "Рафиева": null,
        //         "Радужная": null,
        //         "Родная": null
        //     }
        // };
        // M.Autocomplete.init(clientAddressInput, options);
    }

    clientStreetInput.addEventListener('input', () => {
        clientStreetValue = clientStreetInput.value;
        findStreetByCity(CURRENT_CITY_ID, clientStreetInput.value);
    });

    function findStreetByCity(cityId, char) {
        let findStreet = new XMLHttpRequest();
        console.log(clientCityInput.value);

        findStreet.open('GET', 'https://superresheba.by/market/default/search-street?city_id=' + cityId + '&word=' + char, true);

        findStreet.send();

        findStreet.onreadystatechange = () => {
            if (findStreet.status === 200 && findStreet.readyState === 4) {
                let data = JSON.parse(findStreet.responseText);
                console.log(data);
                let options = {
                    data: {},
                    limit: 10
                };
                for (let i = 0; i < data.length; i++) {
                    options.data[data[i].name] = null;
                }
                M.Autocomplete.init(clientStreetInput, options);
            }
        };
        // let options = {
        //     data: {
        //         "Рафиева": null,
        //         "Радужная": null,
        //         "Родная": null
        //     }
        // };
        // M.Autocomplete.init(clientAddressInput, options);
    }

    clientPhoneInput_mail.addEventListener('input', () => {
        clientPhone_mailValue = clientPhoneInput_mail.value;
    });
    clientPhoneInput_mail.addEventListener('blur', () => {
        let spanError = document.getElementById('error-message');
        if (!isPhoneNumber(clientPhone_mailValue)) {
            if (spanError) {
                spanError.parentNode.removeChild(spanError);
            }
            clientPhoneInput_mail.classList.add('invalid');
            clientPhoneInput_mail.parentElement.insertAdjacentHTML('beforeend', getErrorHtmlSpan(
                "Введите правильный номер телефона"
            ));
        } else {
            spanError.parentNode.removeChild(spanError);
            clientPhoneInput_mail.classList.remove('invalid');
        }
    });

    mailIndex.addEventListener('input', () => {
        mailIndexValue = mailIndex.value;
    });

    homeInfo.addEventListener('input', () => {
        homeInfoValue = homeInfo.value;
    });

    apartmentNumber.addEventListener('input', () => {
        apartmentNumberValue = apartmentNumber.value;
    });

    // mail delivery way checkboxes

    mail_deliveryWayCheckboxes.forEach((mailCheckbox) => {
        mailCheckbox.checked = false;
    });

    function checkOrderInfo() {

    }

    function saveMinskOrderInfo() {
        let deliveryInfo = {
            name: clientNameValue,
            phone: clientPhoneInput.value,
            address: clientAddressInput.value,
            homeInfo: homeInfoMinskValue,
            apartmentNumber: apartmentNumberMinskValue,
            deliveryWay: deliveryWayCheckboxes[0].checked ?
                deliveryWayCheckboxes[0].value : deliveryWayCheckboxes[1].value,
            deliveryTime: clientDeliveryTimeValue,
            deliveryDate: clientTodayInput.checked ? 'today' : clientDeliveryDateInput.value,
            type: 'Minsk'
        };

        data = {
            name: deliveryInfo.name,
            phone: deliveryInfo.phone,
            address: deliveryInfo.address,
            homeInfo: deliveryInfo.homeInfo,
            deliveryWay: deliveryInfo.deliveryWay,
            deliveryTime: deliveryInfo.deliveryTime
        };

        messages = {
            name: 'Ваше имя',
            phone: 'Номер телефона',
            address: 'Ваш адресс',
            homeInfo: 'Дом/Корпус',
            deliveryWay: 'Способо доставки',
            deliveryTime: 'Время доставки'
        };

        if (deliveryInfo.name &&
            deliveryInfo.phone &&
            deliveryInfo.address &&
            deliveryInfo.deliveryWay &&
            deliveryInfo.deliveryTime &&
            deliveryInfo.homeInfo
        ) {
            localStorage.setItem('deliveryInfo', JSON.stringify(deliveryInfo));
            console.log('minsk order has been save');
            return true;
        } else {
            localStorage.setItem('deliveryInfo', JSON.stringify([]));
            document.getElementById('scroll-to-top-validation').click();
            if (document.getElementsByClassName('validation-cart-message')[0] !== undefined) {
                document.getElementById('close-validation-cart-message').click();
            }
            showValidationMessage(data, messages);
            return false;
        }
    }

    function saveMailOrderInfo() {
        let deliveryInfo = {
            fullName: clientFullNameValue,
            phone: clientPhoneInput_mail.value,
            city: clientCityInput.value,
            street: clientStreetInput.value,
            mailIndex: mailIndexValue,
            homeInfo: homeInfoValue,
            apartmentNumber: apartmentNumberValue,
            notificationWays: [],
            type: 'Mail'
        };

        console.log(deliveryInfo.city);

        mail_deliveryWayCheckboxes.forEach((mailCheckbox) => {
            if (mailCheckbox.checked) {
                deliveryInfo.notificationWays.push(mailCheckbox.value);
            }
        });

        data = {
            fullName: deliveryInfo.fullName,
            phone: deliveryInfo.phone,
            city: deliveryInfo.city,
            street: deliveryInfo.street,
            mailIndex: deliveryInfo.mailIndex,
            homeInfo: deliveryInfo.homeInfo,
        };

        messages = {
            fullName: 'ФИО',
            phone: 'Номер телефона',
            city: 'Город/деревня',
            street: 'Улица',
            mailIndex: 'Почтовый индекс',
            homeInfo: 'Дом/Корпус',
        };

        if (deliveryInfo.fullName &&
            deliveryInfo.phone &&
            deliveryInfo.city &&
            deliveryInfo.street &&
            deliveryInfo.mailIndex &&
            deliveryInfo.homeInfo
        ) {
            localStorage.setItem('deliveryInfo', JSON.stringify(deliveryInfo));
            console.log('mail order has been save');
            return true;
        } else {
            console.log('Не все поля заполнены');
            document.getElementById('scroll-to-top-validation').click();
            if (document.getElementsByClassName('validation-cart-message')[0] !== undefined) {
                document.getElementById('close-validation-cart-message').click();
            }
            showValidationMessage(data, messages);
            return false;
        }
    }

    function showValidationMessage(dataArray, messages) {

        let messageStack = [];

        for (let key in dataArray) {
            if (dataArray[key] === undefined || dataArray[key] === '') {
                messageStack.push(messages[key]);
            }
        }

        let resultList = '';

        for (let i = 0; i < messageStack.length; i++) {
            resultList += '<li>' + messageStack[i] + '</li>';
        }

        let resultMessage = '<div class="card-panel validation-cart-message"><span>Заполните пожалуйста следующие поля:</span><ul class="validation-cart-ul">' + resultList + '</ul><a id="close-validation-cart-message"><i class="material-icons">close</i></a></div>';

        let htmlMessage = document.createElement('div');
        htmlMessage.innerHTML = resultMessage;

        firstStepBlock.parentNode.insertBefore(htmlMessage, firstStepBlock);
        M.toast({html: 'Вы заполнили не все поля'});
        document.getElementById('close-validation-cart-message')
            .addEventListener('click', () => {
                document.getElementById('close-validation-cart-message').parentNode.parentNode.removeChild(
                    document.getElementById('close-validation-cart-message').parentNode
                );
            });
    }

    let socket = new WebSocket('ws://localhost:8080');

    socket.onopen = () => {
        console.log('Connection has been opened');
    };

    socket.onclose = () => {
        console.log('Connection has been closed');
    };

    socket.onerror = (error) => {
      console.log(`Error code: ${error.message}`);
    };

    function sendResultData() {
        let cartInfo = JSON.parse(localStorage.getItem('cartInfo'));
        let orderInfo = JSON.parse(localStorage.getItem('deliveryInfo'));

        let saveOrder = new XMLHttpRequest();
        saveOrder.open('POST', '/api/order/new', true);

        // let resultArray = {
        //     'products': null,
        //     'orderInfo': null
        // };
        //
        // resultArray.products = JSON.parse(cartInfo);

        const DRIVER_COST_DELIVERY = 5;
        const MAIL_COST_DELIVERY = 3;

        let resultData = new FormData();
        resultData.append('products', JSON.stringify(cartInfo));
        resultData.append('orderCost', localStorage.getItem('totalSum'));
        if (orderInfo.type === 'Minsk') {
            let deliveryDate;
            if (clientTodayInput.checked) {
                deliveryDate = 'today'
            } else {
                deliveryDate = orderInfo.deliveryDate;
            }
            resultData.append('street', orderInfo.address);
            resultData.append('homeIndex', null);
            resultData.append('apartmentNumber', null);
            resultData.append('city', 'Минск');
            resultData.append('firstName', orderInfo.name);
            resultData.append('phoneNumber', orderInfo.phone);
            resultData.append('deliveryWay', orderInfo.deliveryWay);
            resultData.append('deliveryDate', deliveryDate);
            resultData.append('deliveryTime', orderInfo.deliveryTime);
            resultData.append('homeNumber', orderInfo.homeInfo);
            resultData.append('apartmentNumber', orderInfo.apartmentNumber);
            if (orderInfo.deliveryWay === 'driver') {
                resultData.append('deliveryCost', DRIVER_COST_DELIVERY);
            } else {
                resultData.append('deliveryCost', 0);
            }
            resultData.append('type', 'Minsk');
            resultData.append('email', emailForPromoValue);
        } else {
            resultData.append('street', orderInfo.street);
            resultData.append('homeIndex', orderInfo.homeInfo);
            resultData.append('apartmentNumber', orderInfo.apartmentNumber);
            resultData.append('city', orderInfo.city);
            resultData.append('fullName', orderInfo.fullName);
            resultData.append('postIndex', orderInfo.mailIndex);
            resultData.append('phoneNumber', orderInfo.phone);
            resultData.append('homeNumber', orderInfo.homeInfo);
            resultData.append('deliveryWay', 'mail');
            resultData.append('type', 'Mail');
            resultData.append('email', emailForPromoValue);
            resultData.append('deliveryCost', MAIL_COST_DELIVERY);
        }

        saveOrder.send(resultData);

        saveOrder.onreadystatechange = () => {
            if (saveOrder.status === 200 && saveOrder.readyState === 4) {
                let sendedData = {
                    orderId: JSON.parse(saveOrder.responseText)['orderId']
                };
                socket.send(JSON.stringify(sendedData));
                setTimeout(() => {
                    // show promocode
                    let promocode = JSON.parse(saveOrder.responseText).promoCode;
                    let promocodeHtml = '<h5>Ваш промокод: <span>' + promocode + '</span></h5>';
                    promocodeBlock.innerHTML = promocodeHtml;
                    loaderBlock.parentNode.removeChild(loaderBlock);
                    showSuccessOrder();
                }, 300)
                // console.log(saveOrder.responseText);
            }
        };

        function showSuccessOrder() {
            console.log(scrollToTop);
            scrollToTop.click();
            // show order success block
            successBlock.classList.remove('dn');
            // enable footer
            siteFooter.classList.remove('dn');
            // clear localStorage
            localStorage.clear();
        }

        // let ajax = new XMLHttpRequest();
        // ajax.open('POST', '/api/order/get-products', true);
        //
        // let ids = [];
        //
        // JSON.parse(localStorage.getItem('cartInfo')).forEach((orderInfo) => {
        //     ids.push(orderInfo.productId);
        // });
        //
        // let formData = new FormData();
        // formData.append('ids', JSON.stringify(ids));
        //
        // ajax.send(formData);
        //
        // ajax.onreadystatechange = () => {
        //     if (ajax.status === 200) {
        //         let orderedProducts = JSON.parse(ajax.responseText);
        //         renderOrderedProducts(orderedProducts);
        //     }
        // };

    }

    //
    // function renderOrderInfoOnThirdStep(order) {
    //     console.log(order);
    //     let currentDeliveryWay = order.deliveryWay === 'driver' ? 'Курьером' : 'Самовывоз';
    //     thirdStepBlock.innerHTML = "<div><h2>Имя клиента: " + order.name + "</h2><h2>Номер телефона: " + order.phone + "</h2><h2>Адрес: " + order.address + "</h2><h2>Способ доставки: " + currentDeliveryWay + "</h2><h2>Время доставки: " + order.deliveryTime + "</h2></div>";
    // }

    // deliveryWayCheckboxes.forEach((checkbox) => {
    //
    // });


    function renderOrderedProducts(products) {
        let productsBlock = "";
        let storedProducts = JSON.parse(localStorage.getItem('cartInfo'));
        let promocodeField = '<div class="input-field promocode-field col s2"><input id="promo_code" oninput="listenerOfPromoInput()" type="text"><label for="promo_code">Ваш промокод</label><a class="btn" onclick="recalculateTotalSumByPromocode()" id="recalculate-total-sum">Пересчитать</a></div>';
        let nextButtonNew = '<div class=""><a class="btn nextButton" id="nextButton">Продолжить</a></div>';
        products.forEach((product) => {
            let productCount = storedProducts.find(p => +p.productId === +product.id).count;
            let minusButtonClass = '';
            if (+productCount === 1) {
                minusButtonClass = 'dn'
            }
            let totalPrice = storedProducts.find(p => +p.productId === +product.id)['totalPrice'];
            let standartPrice = storedProducts.find(p => +p.productId === +product.id).price;
            // result total product price
            let productPrice = totalPrice !== undefined ? +totalPrice : +standartPrice;
            productsBlock += "<div class=\"row product-row product-section\"><div class=\"col xl5 l5 m7 s12\"><div class=\"row margin-min\"><div class=\"col xl6 l6 m6 s6 image-col\"><div class=\"image-in-cart\"><img class=\"materialboxed\" src=\"uploads/img/product/" + product.previewPhoto + "\" alt=\"\"></div></div><div class=\"col xl6 l6 m6 s6 product-info-col\"><div class=\"name-of-product\"><h5>" + product.name + "</h5><p style='word-wrap: break-word;'>" + product.shortDescription.slice(0, 80) + "</p></div></div></div></div><div class=\"col xl2 l2 m5 s2 offset-xl2 offset-l2 hide-on-small-and-down\"><div class=\"count-of-product\"><i class='material-icons " + minusButtonClass + "' onclick='minusProduct(" + product.id + ", this)' id='remove-product-button'>remove</i><span class='span-product-count'>" + productCount + "</span><i class='material-icons' id='add-product-button' onclick='plusProduct(" + product.id + ", this)'>add</i><a onclick='removeProduct(" + product.id + ", this)' class='btn btn-floating delete-product' id='delete-product-imitation-" + product.id + "' data-product-id='" + product.id + "'><i class='material-icons'>delete</i></a></div></div><div class=\"col xl3 l3 m5 s3 hide-on-small-and-down\"><div class=\"price-of-product\"><span class='span-price-of-product'>" + productPrice + " BYN</span></div></div><div class=\"col s12 hide-on-med-and-up count-price-on-mobile\"><div class=\"price-of-product-mobile\"><span class='span-price-of-product'>" + productPrice + " BYN</span></div><div class=\"count-of-product-mobile\"><i class='material-icons " + minusButtonClass + "' id='remove-product-button-mobile' onclick='minusProduct(" + product.id + ", this)'>remove</i><span class='span-product-count'>" + productCount + " шт.</span><i class='material-icons' id='add-product-button-mobile' onclick='plusProduct(" + product.id + ", this)'>add</i><a onclick='removeProduct(\" + product.id + \", this)' id='delete-product-imitation-" + product.id + "' class='btn btn-floating delete-product-small' data-product-id='" + product.id + "'><i class='material-icons'>delete</i></a></div></div></div>";
        });
        localStorage.setItem('totalSum', JSON.stringify(calculateTotalSum(JSON.parse(localStorage.getItem('cartInfo')))));
        let totalSumInfo = "<div class='cart-bonus-block'><h2 class='bones-caption for-total-sum'>Итого: <span class='total-sum-value' id='cart-total-sum'>" + calculateTotalSum(JSON.parse(localStorage.getItem('cartInfo'))) + " BYN</span></h2><span class='color-detail'>Уточняте цвет товара у курьера</span></div>";
        firstStepBlock.innerHTML = productsBlock;
        firstStepBlock.innerHTML += totalSumInfo;
        firstStepBlock.innerHTML += promocodeField;
        firstStepBlock.innerHTML += nextButtonNew;
        nextButton = document.getElementById('nextButton');
        nextButton.addEventListener('click', () => {
            nextStep.click();
        });
        promoCode = document.getElementById('promo_code');
        recalculateButton = document.getElementById('recalculate-total-sum');
        let promocodeInfo = JSON.parse(localStorage.getItem('promocode'));
        if (promocodeInfo !== null) {
            let cartSum = document.getElementById('cart-total-sum');
            let newPrice = Math.ceil(calculateTotalSum(JSON.parse(localStorage.getItem('cartInfo'))) * (1 - promocodeInfo.percent));
            cartSum.innerHTML = newPrice + ' BYN';
            cartSum.parentNode.parentElement.innerHTML += '<div class="after-promo-block"><span class="after-promo-ticket">' + promocodeInfo.percent * 100 + '% скидка</span></div>';
            localStorage.setItem('totalSum', newPrice);
            // Remove promo block
            let promoCodeField = document.getElementsByClassName('promocode-field')[0];
            // Delete buttons
            recalculateButton.parentNode.removeChild(recalculateButton);
            promoCodeField.parentNode.removeChild(promoCodeField);
            document.getElementsByClassName('cart-bonus-block')[0].classList.add('no-promo');
        }
        removeProductButton = document.getElementById('remove-product-button');
        addProductButton = document.getElementById('add-product-button');
    }

    // recalculateButton.onclick = () => {
    //     recalculateTotalSumByPromocode(promoCode.value);
    //     console.log('recalculate');
    // };


    function checkoutCartInfo() {
        if (localStorage.getItem('cartInfo') !== null) {
            productCount.innerText = JSON.parse(localStorage.getItem('cartInfo')).length;
        }
    }


};

function minusProduct(productId, obj)
{
    // if (obj.id === 'remove-product-button-mobile') {
    //     removeProductButton.click();
    //     return;
    // }

    let products = JSON.parse(localStorage.getItem('cartInfo'));

    let currentProductCount = 0;

    for (let i = 0; i < products.length; i++) {
        if (+products[i].productId === +productId) {
            // let deleteButt = document.getElementById('delete-product-imitation-' + productId.toString());
            // deleteButt.click();
            if (+products[i].count === 2) {
                products[i].count--;
                obj.classList.add('dn');
            } else {
                products[i].count--;
            }
        }
    }

    currentProductCount = products.find(p => +p.productId === +productId).count;
    let spanProductCount = obj.parentElement.parentElement.parentElement.querySelectorAll('.span-product-count');
    for (let i = 0; i < spanProductCount.length; i++) {
        spanProductCount[i].innerText = currentProductCount.toString() + " шт.";
    }

    let productPrice = products.find(p => +p.productId === +productId).price;
    products.find(p => +p.productId === +productId)['totalPrice'] = (productPrice * currentProductCount).toString();

    let productPrices = obj.parentElement.parentElement.parentElement.querySelectorAll('.span-price-of-product');

    for (let i = 0; i < productPrices.length; i++) {
        productPrices[i].innerText = (productPrice * currentProductCount).toString() + " BYN";
    }

    localStorage.setItem('cartInfo', JSON.stringify(products));

    recalculateTotalSum();
}

function plusProduct(productId, obj)
{
    // if (obj.id === 'add-product-button-mobile') {
    //     addProductButton.click();
    //     return;
    // }

    let products = JSON.parse(localStorage.getItem('cartInfo'));

    let currentProductCount = 0;

    for (let i = 0; i < products.length; i++) {
        if (+products[i].productId === +productId) {
            // let deleteButt = document.getElementById('delete-product-imitation-' + productId.toString());
            // deleteButt.click();
            if (+products[i].count === 1) {
                products[i].count++;
                let rpb = obj.parentElement.querySelector('#remove-product-button');
                let rpbm = obj.parentElement.querySelector('#remove-product-button-mobile');
                if (rpb !== null) {
                    rpb.classList.remove('dn');
                }
                if (rpbm !== null) {
                    rpbm.classList.remove('dn');
                }
            } else {
                products[i].count++;
            }
        }
    }

    currentProductCount = products.find(p => +p.productId === +productId).count;
    let spanProductCount = obj.parentElement.parentElement.parentElement.querySelectorAll('.span-product-count');
    for (let i = 0; i < spanProductCount.length; i++) {
        spanProductCount[i].innerText = currentProductCount.toString() + " шт.";
    }

    let productPrice = products.find(p => +p.productId === +productId).price;
    products.find(p => +p.productId === +productId)['totalPrice'] = (productPrice * currentProductCount).toString();

    let productPrices = obj.parentElement.parentElement.parentElement.querySelectorAll('.span-price-of-product');

    for (let i = 0; i < productPrices.length; i++) {
        productPrices[i].innerText = (productPrice * currentProductCount).toString() + " BYN";
    }

    localStorage.setItem('cartInfo', JSON.stringify(products));

    recalculateTotalSum();
}

function recalculateTotalSum()
{
    let totalSumSection = document.getElementsByClassName('total-sum-value')[0];
    let products = JSON.parse(localStorage.getItem('cartInfo'));

    let totalSum = 0;

    for (let i = 0; i < products.length; i++) {
        totalSum += products[i]['totalPrice'] !== undefined ? +products[i]['totalPrice'] : +products[i].price;
    }

    let promocode = JSON.parse(localStorage.getItem('promocode'));

    if (promocode !== null) {
        totalSumSection.innerHTML = (Math.ceil(totalSum * (1 - +promocode.percent))).toString() + " BYN";
    } else {
        totalSumSection.innerHTML = totalSum.toString() + " BYN";
    }

    localStorage.setItem('totalSum', totalSum.toString());
}

function listenerOfPromoInput()
{
    promoCodeValue = promoCode.value;
    console.log(promoCodeValue);
}

function recalculateTotalSumByPromocode()
{
    let promovalue = document.getElementById('promo_code').value;
    console.log(promovalue);
    let promo = new XMLHttpRequest();
    promo.open('GET', '/api/order/recalculate-promocode?promoCode=' + promovalue, true);
    promo.send();

    promo.onreadystatechange = () => {
        if (promo.status === 200 && promo.readyState === 4) {
            let errorAlert = document.getElementsByClassName('error-promo-alert')[0];
            if (errorAlert !== undefined) {
                errorAlert.parentNode.removeChild(errorAlert);
            }
            let percent = JSON.parse(promo.responseText).percent;
            percent = percent / 100;
            let newPrice = Math.ceil(+localStorage.getItem('totalSum') * (1 - percent));
            let cartSum = document.getElementById('cart-total-sum');
            cartSum.innerHTML = newPrice + ' BYN';
            let promoCodeField = document.getElementsByClassName('promocode-field')[0];
            // Delete buttons
            recalculateButton.parentNode.removeChild(recalculateButton);
            promoCodeField.parentNode.removeChild(promoCodeField);
            cartSum.parentNode.parentElement.innerHTML += '<div class="after-promo-block"><span class="after-promo-ticket">' + percent * 100 + '% скидка</span></div>';
            document.getElementsByClassName('cart-bonus-block')[0].classList.add('no-promo');
            localStorage.setItem('totalSum', newPrice);
            let promocodeInfo = {
              percent: percent,
              promocode_id: JSON.parse(promo.responseText).promocode_id
            };
            localStorage.setItem('promocode', JSON.stringify(promocodeInfo));
        }
        if (promo.status === 400 && JSON.parse(promo.responseText).error && promo.readyState === 4) {
            let errorAlert = document.getElementsByClassName('error-promo-alert')[0];
            if (errorAlert !== undefined) {
                errorAlert.parentNode.removeChild(errorAlert);
            }
            firstStepBlock.innerHTML += '<div class="error-promo-alert"><span>Вы ввели неверный промокод</span></div>';
            document.getElementsByClassName('promocode-field')[0].classList.add('lite-mb');
            console.log(JSON.parse(promo.responseText).error);
            // promoCode.value = "";
            promoCodeValue = "";
            promoCode.value = "";
        }
    }
}

function tabSelected(tabName) {
    switch (tabName) {
        case 'first':
            links.find(l => l.value.classList.contains('active')).value.classList.remove('active');
            firstStepLink.classList.add('active');
            activeLink = links.find(l => l.id === 1);
            prevStep.parentElement.classList.add('hide');
            replaceStepInfo('stepOne');
            nextStep.innerText = 'Продолжить';
            break;
        case 'second':
            secondStepLink.click();
            tabMinsk.click();
            activeLink = links.find(l => l.id === 2);
            replaceStepInfo('stepTwo');
            nextStep.innerText = 'Продолжить';
            break;
        case 'third':
            secondStepLink.classList.remove('active');
            thirdStepLink.classList.add('active');
            activeLink = links.find(l => l.id === 3);
            prevStep.parentElement.classList.remove('hide');
            replaceStepInfo('stepThree');
            nextStep.innerText = 'Оформить';
            break;
    }
}

function replaceStepInfo(stepName) {
    stepInfoElement.innerHTML = steps.find(s => s.name === stepName).description;
    mainCartCaption.innerText = steps.find(s => s.name === stepName).short;
    mainCartIcon.innerText = steps.find(s => s.name === stepName).iconClass;
    modalHeader.append(stepInfoElement);
}

function removeProduct(id, el) {
    let savedProducts = JSON.parse(localStorage.getItem('cartInfo'));
    if (productSectionBlocks.length === 1) {
        el.parentNode.parentNode.parentNode.parentNode.removeChild(el.parentNode.parentNode.parentNode);
        firstStepBlock.innerHTML = "<h6 class='center-align'>Ваша корзина пуста</h6>";
        localStorage.clear();
        M.toast({html: 'Продукт удален. Ваша корзина пуста'});
    } else {
        el.parentNode.parentNode.parentNode.parentNode.removeChild(el.parentNode.parentNode.parentNode);
        M.toast({html: 'Продукт удален'});
        for (let i = 0; i < savedProducts.length; i++) {
            if (savedProducts[i].productId === el.getAttribute('data-product-id')) {
                savedProducts.splice(i, 1);
            }
        }
        localStorage.setItem('cartInfo', JSON.stringify(savedProducts));

        // let currentTotalSum = calculateTotalSum(JSON.parse(localStorage.getItem('cartInfo')));
        // console.log(currentTotalSum);
        // let sum = 0;
        // for (let j = 0; j < savedProducts.length; j++) {
        //     sum += +savedProducts[j].price;
        // }
        // console.log(sum.toString() + " BYN");
        // let cartSum = document.getElementById('cart-total-sum');
        // cartSum.innerHTML = sum.toString() + " BYN";
        // localStorage.removeItem('totalSum');
        // localStorage.setItem('totalSum', sum);
        recalculateTotalSum();
    }
}

function calculateTotalSum(productsList) {

    let totalSum = 0;
    productsList.forEach((product) => {
        totalSum += product['totalPrice'] !== undefined ? +product['totalPrice'] : +product.price;
    });

    return totalSum;
}

// deleteProductsButtons_large.forEach((button) => {
//     button.addEventListener('click', () => {
//         console.log(button);
//     });
// });