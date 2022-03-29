$(document).ready(function(){
    $("#sort").change(function(){
        var option = $(this).find(":selected").val();
        sessionStorage.setItem("selectedOption", option);
        var optionValue = $(this).selectedIndex;
        $.ajax({
            type: "POST",
            url: "inventory.php",
            data: {
                selected: option
            },
            success: function(data) { 
                $("#display").html(data);
            }
        });
        
    })
    $('#sort').find('option[value='+sessionStorage.getItem('selectedOption')+']').attr('selected','selected');

})