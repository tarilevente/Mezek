$(document).ready(function () {
  //Whern select "nemzeti valogatott" , this code navigates there
  $(document).on("click", "#nemzetiSelect", function () {
    console.log("itt");
    window.location = "nemzeti.php";
  });

  //fills #nemzetiDiv with content by post
  $("#nemzetiDiv").ready(function () {
    $.post("php/nemzetiDiv.php", { nemzeti: 1 }, function (adat) {
      $("#nemzetiDiv").html(adat);
    });
  });

  //print selected national data by nemzetiDiv.php
  $(document).on("click", ".data-national", function () {
    const nId = $(this).attr("data-nationalID");
    console.log("national " + nId);
    $.ajax({
      url: "php/nemzetiTeams.php",
      method: "POST",
      dataType: "text",
      data: { nId: nId },
      success: function (response) {
        $("#nationalTeams").html(response);
      },
      error: function () {},
    });
  }); //endof print selected nation
});
