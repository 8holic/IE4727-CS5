"use strict";
// Part 4(ii) & Part 5(ii): calculate order totals using CURRENT database prices
// printed into the HTML by menu.php. The server recalculates independently on checkout.

const JavaNode = document.getElementById('QtyJava');
const CafeNode1 = document.getElementById('Qty_Cafe_Single');
const CafeNode2 = document.getElementById('Qty_Cafe_Double');
const CafeNode3 = document.getElementById('QtyCafe');
const CapNode1 = document.getElementById('Qty_Cap_Single');
const CapNode2 = document.getElementById('Qty_Cap_Double');
const CapNode3 = document.getElementById('QtyCap');

// A blank quantity means "not ordered". Otherwise only whole numbers 0...999.
function quantityOf(node) {
    const raw = node.value.trim();
    const valid = raw === '' || (/^\d+$/.test(raw) && Number(raw) <= 999);
    node.setCustomValidity(valid ? '' : 'Enter a whole-number quantity from 0 to 999.');
    return valid ? (raw === '' ? 0 : Number(raw)) : NaN;
}

function subtotal(quantityNode, radioNodes, outputId, fixedPrice = null) {
    const qty = quantityOf(quantityNode);
    const chosen = radioNodes ? radioNodes.find(radio => radio.checked) : null;
    if (radioNodes) {
        quantityNode.setCustomValidity(qty > 0 && !chosen ? 'Choose Single or Double first.' : quantityNode.validationMessage);
    }
    const price = fixedPrice !== null ? fixedPrice : (chosen ? Number(chosen.dataset.price) : 0);
    const amount = qty * price;
    document.getElementById(outputId).value = Number.isFinite(amount) ? amount.toFixed(2) : '';
    return Number.isFinite(amount) ? amount : 0;
}

function Cal_Java() {
    subtotal(JavaNode, null, 'Price_Java', Number(JavaNode.dataset.price));
    Cal_total();
}
function Cal_Cafe() {
    subtotal(CafeNode3, [CafeNode1, CafeNode2], 'Price_Cafe');
    Cal_total();
}
function Cal_Cap() {
    subtotal(CapNode3, [CapNode1, CapNode2], 'Price_Cap');
    Cal_total();
}
function Cal_total() {
    const java = Number(document.getElementById('Price_Java').value) || 0;
    const cafe = Number(document.getElementById('Price_Cafe').value) || 0;
    const cap = Number(document.getElementById('Price_Cap').value) || 0;
    document.getElementById('TotalPrice').value = (java + cafe + cap).toFixed(2);
}

JavaNode.addEventListener('input', Cal_Java);
CafeNode3.addEventListener('input', Cal_Cafe);
CapNode3.addEventListener('input', Cal_Cap);
[ CafeNode1, CafeNode2 ].forEach(node => node.addEventListener('change', Cal_Cafe));
[ CapNode1, CapNode2 ].forEach(node => node.addEventListener('change', Cal_Cap));
Cal_Java(); Cal_Cafe(); Cal_Cap();
