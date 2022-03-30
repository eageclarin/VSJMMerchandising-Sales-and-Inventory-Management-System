function fill(Value) {
    $('#search').val(Value);
    $('#display').hide();
 }

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
    
$(document).ready(function(){
        $("#search").keyup(function() {
        var input = $(this).val();
        //alert(input);
       // if (input == "") {  
            //$("#display").html("");

       // }
       //  else {
            $.ajax({
                type: "POST",
                url: "search_sort.php",
                data: {
                    search: input
                },
                success: function(data) {
                    $("#display").html(data);
                }
            });
       // };
    });

    $("#sort").change(function(){
        var option = $(this).find(":selected").val();
        sessionStorage.setItem("selectedOption", option);
        var optionValue = $(this).selectedIndex;
        $.ajax({
            type: "POST",
            url: "search_sort.php",
            data: {
                selected: option
            },
            success: function(data) { 
                $("#display").html(data);
            }
        });
        
    })
    $('#sort').find('option[value='+sessionStorage.getItem('selectedOption')+']').attr('selected','selected');

});