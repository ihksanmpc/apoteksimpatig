const getTotal = document.getElementById('total');
const getDiskon = document.getElementById('diskon');
const getGrandTotal = document.getElementById('grandtotal');
const textGrandTotal = document.getElementById('textGrandTotal');

window.addEventListener('load', () => {
    countDiscount(getTotal.value, getDiskon.value)
});

getDiskon.addEventListener('change', () => {
    countDiscount(getTotal.value, getDiskon.value)
});

function countDiscount(total, diskon) {
    let result = total - diskon);
    getGrandTotal.value = result;
    textGrandTotal.innerText = new Intl.NumberFormat('id-ID').format(result);
}