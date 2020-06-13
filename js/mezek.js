$(document).ready(function(){

    //Whern select "nemzeti valogatott" , this code navigates there
    $(document).on('click','#nemzetiSelect',function(){
        console.log("itt");
        window.location="nemzeti.php";
    });

    //fills #nemzetiDiv with content by post
    $("#nemzetiDiv").ready(function(){
        $.post('php/nemzetiDiv.php',{nemzeti:1},function(adat){
            $("#nemzetiDiv").html(adat);
        });
    });



    
});