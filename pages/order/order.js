function showItems(categ) { //display items by categ
    $.ajax({
        url: 'getItem.php?categ='+categ,
        success: function(html) {
        var display = document.getElementById('list');
        display.innerHTML = html;
        }
    });
};

function showResult(str) {
  $.ajax({
      url: 'getItem.php?q='+str,
      success: function(html) {
          var search = document.getElementById('livesearch');
          search.innerHTML=html;
          search.style.border="1px solid #A5ACB2"; 
      }
  });
};

function showResult(str) {
  $.ajax({
    url: 'getItem.php?q='+str,
    success: function(html) {
      var search = document.getElementById('datalistOptions');
      search.append(html);
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
    document.getElementById("change").value = change + ".00";

    if (change < 0) {
        document.getElementById('pay').disabled = true;
    } else {
        document.getElementById('pay').disabled = false;
    }
}