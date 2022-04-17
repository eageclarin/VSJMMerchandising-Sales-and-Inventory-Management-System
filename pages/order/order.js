//change qty
function changeQty(getID, getQty) {
    var dataString = "action=update&itemID="+getID+"&qty="+getQty;
  
    $.ajax({
      type: "GET",
      url: "updateItem.php",
      data: dataString,
      success: function(data) {
        $("#itemTotal-"+getID).html(data);
        $("#update").innerHTML("Item quantity update.");
        totalPrice();
      }
    });
  
    return false;
}

//update total price
function totalPrice() {
    var dataString = "action=total";
  
    $.ajax({
      type: "GET",
      url: "updateItem.php",
      data: dataString,
      success: function(data){
        $("#total").html(data);
        $("#totalOrder").val(data);
      }
    });
}

//calculateChange
function calculateChange(money) {
    var change = money - document.getElementById("totalOrder").value;
    document.getElementById("change").value = change.toFixed(2);

    if (change < 0) {
        document.getElementById('pay').disabled = true;
    } else {
        document.getElementById('pay').disabled = false;
    }
}