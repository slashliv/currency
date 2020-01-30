'use strict';

const CURRENCY_TIMEOUT = 10 * 1000;

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

getCurrency();

function getCurrency() {
    axios.get('/').then(function (response) {
        let data = response.data;
        if (!data.success) {
            alert(data.error);

            return;
        }

        document.getElementById('current_currency').innerText = data.currency;
        setTimeout(function () {
            getCurrency();
        }, CURRENCY_TIMEOUT);
    });
}
