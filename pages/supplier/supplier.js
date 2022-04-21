function fill(Value) {
    $('#search').val(Value);
    $('#display').hide();
 }
/*
function add(){
    alert("found i");
    $.ajax({
        type: "POST",
        url: "addpending.php",
        data: {
            pending_ItemID: '<?php echo $_SESSION["pending_ItemID"]?>'
        },
        success: function(data) {  
            $("#dummy").html(data);
        }
    });
}
*/

function edit(){
    $('#staticBackdrop').modal('show');
    alert("hi");
}

//CHECK SUPPLIERS FROM THE ITEM LIST IN INVENTORY
$(window).on('load', function() {
        var input = $("#search").val();
        var option = $("#sort").find(":selected").val();
        sessionStorage.setItem("selectedOption", option);
        var optionValue = $("#sort").selectedIndex;

            $.ajax({
                type: "POST",
                url: "search_sort_item.php",
                data: {
                    search: input,
                    selected: option
                },
                success: function(data) {
                    $("#display").html(data);
                }
            });
});

//SEARCH AND SORT BY
$(document).ready(function(){

    $("#search").keyup(function() {
        var input = $("#search").val();
        var option = $("#sort").find(":selected").val();
        sessionStorage.setItem("selectedOption", option);
        var optionValue = $("#sort").selectedIndex;

            $.ajax({
                type: "POST",
                url: "search_sort_item.php",
                data: {
                    search: input,
                    selected: option
                },
                success: function(data) {
                    $("#display").html(data);
                }
            });

    });

    $("#sort").change(function(){
        var input = $("#search").val();
        var option = $("#sort").find(":selected").val();
        sessionStorage.setItem("selectedOption", option);
        var optionValue = $("#sort").selectedIndex;
        $.ajax({
            type: "POST",
            url: "search_sort_item.php",
            data: {
                search: input,
                selected: option
            },
            success: function(data) { 
                $("#display").html(data);
            }
        });
        
    });

});