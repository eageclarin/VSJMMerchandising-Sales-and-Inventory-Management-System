function showItems(categ) { //display items by categ
    $.ajax({
        url: 'getItem.php?categ='+categ,
        success: function(html) {
        var display = document.getElementById('list');
        display.innerHTML = html;
        }
    });
};