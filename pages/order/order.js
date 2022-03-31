function showItems(categ) { //display items by categ
    $.ajax({
        url: 'getItem.php?categ='+categ,
        success: function(html) {
        var display = document.getElementById('list');
        display.innerHTML = html;
        }
    });
};

//change qty
function changeQty(getID, getQty) {
    var dataString = "action=update&itemID="+getID+"&qty="+getQty;
  
    $.ajax({
      type: "GET",
      url: "updateItem.php",
      data: dataString,
      success: function(data) {
        $("#itemTotal-"+getID).html(data);
  
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
        $("#total").html(data+".00");
        $("#totalOrder").val(data+".00");
      }
    });
}

//calculateChange
function calculateChange(money) {
    var change = money - document.getElementById("totalOrder").value;
    document.getElementById("change").value = change + ".00";
}