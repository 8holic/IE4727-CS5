var JavaNode = document.getElementById("QtyJava");

JavaNode.addEventListener("change", Cal_Java, false);


function Cal_Java(event){
    var qtyJavaChk = event.currentTarget;
    
    var pos = qtyJavaChk.value.search(/^[0-9]*$/);

    if(pos !=0)
    {
        alert("You entered("+ qtyJavaChk.value +") is not correct.\n" + "Only NUMBER are allowed.");
        qtyJavaChk.value = "";
        document.getElementById("Price_Java").value = "";
        qtyJavaChk.focus();

        return false;
    
    
    }

    //just java cost $2

    var Total_Java_Price = 2*JavaNode.value;

    document.getElementById("Price_Java").value = parseFloat(Total_Java_Price).toFixed(2);

    Cal_total();
    
}


// cafe au lait


var CafeNode1 = document.getElementById("Qty_Cafe_Single");
var CafeNode2 = document.getElementById("Qty_Cafe_Double");
var CafeNode3 = document.getElementById("QtyCafe");


CafeNode1.addEventListener("change", Cal_Cafe, false);
CafeNode2.addEventListener("change", Cal_Cafe, false);
CafeNode3.addEventListener("change", Cal_Cafe, false);

function Cal_Cafe(event)
{
    var qtyCafeChk = CafeNode3;

    // Check that quantity contains numbers only
    var pos = qtyCafeChk.value.search(/^[0-9]*$/);

    if (pos != 0)
    {
        alert("You entered (" + qtyCafeChk.value + ") is not correct.\n" +
              "Only NUMBER are allowed.");

        qtyCafeChk.value = "";
        document.getElementById("Price_Cafe").value = "";
        qtyCafeChk.focus();

        return false;
    }

    var Total_Cafe_Price = 0;

    // Single shot selected
    if (CafeNode1.checked == true)
    {
        Total_Cafe_Price = CafeNode1.value * CafeNode3.value;

        document.getElementById("Price_Cafe").value =
            parseFloat(Total_Cafe_Price).toFixed(2);
    }

    // Double shot selected
    if (CafeNode2.checked == true)
    {
        Total_Cafe_Price = CafeNode2.value * CafeNode3.value;

        document.getElementById("Price_Cafe").value =
            parseFloat(Total_Cafe_Price).toFixed(2);
    }

    Cal_total();
}




// iced cuppucino


var CapNode1 = document.getElementById("Qty_Cap_Single");
var CapNode2 = document.getElementById("Qty_Cap_Double");
var CapNode3 = document.getElementById("QtyCap");

CapNode1.addEventListener("change", Cal_Cap, false);
CapNode2.addEventListener("change", Cal_Cap, false);
CapNode3.addEventListener("change", Cal_Cap, false);


function Cal_Cap(event)
{
    var qtyCapChk = CapNode3;

    // Check that quantity contains numbers only
    var pos = qtyCapChk.value.search(/^[0-9]*$/);

    if (pos != 0)
    {
        alert("You entered (" + qtyCapChk.value + ") is not correct.\n" +
              "Only NUMBER are allowed.");

        qtyCapChk.value = "";
        document.getElementById("Price_Cap").value = "";
        qtyCapChk.focus();

        return false;
    }

    var Total_Cap_Price = 0;

    // single shot selected
    if (CapNode1.checked == true)
    {
        Total_Cap_Price = CapNode1.value * CapNode3.value;

        document.getElementById("Price_Cap").value =
            parseFloat(Total_Cap_Price).toFixed(2);
    }

    // Double shot selected
    if (CapNode2.checked == true)
    {
        Total_Cap_Price = CapNode2.value * CapNode3.value;

        document.getElementById("Price_Cap").value =
            parseFloat(Total_Cap_Price).toFixed(2);
    }

    Cal_total();
}




// CALCULATE OVERALL TOTAL


function Cal_total()
{
    var JavaPrice =
        parseFloat(document.getElementById("Price_Java").value) || 0;

    var CafePrice =
        parseFloat(document.getElementById("Price_Cafe").value) || 0;

    var CapPrice =
        parseFloat(document.getElementById("Price_Cap").value) || 0;

    var TotalPrice = JavaPrice + CafePrice + CapPrice;

    document.getElementById("TotalPrice").value =
        TotalPrice.toFixed(2);
}