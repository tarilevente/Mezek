$(document).ready(function () {
  //Whern select "nemzeti valogatott" , this code navigates there
  $(document).on("click", "#nemzetiSelect", function () {
    console.log("itt");
    window.location = "nemzeti.php";
  });

  //fills #nemzetiDiv with content by post
  $("#nemzetiDiv").ready(function () {
    $.ajax({
      url: "php/nemzetiDiv.php",
      method: "POST",
      dataType: "text",
      data: { nemzeti: 1 },
      success: function (adat) {
        $("#nemzetiDiv").html(adat);
      },
      error: function (adat) {},
    });
  });

  //print selected national data by nemzetiDiv.php
  $(document).on("click", ".data-national", function () {
    const nId = $(this).attr("data-nationalID");
    const err = document.getElementById("nationalTeams");
    console.log(nId);
    $.ajax({
      url: "php/nemzetiTeamsShow.php",
      method: "POST",
      dataType: "text",
      data: { nId: nId },
      success: function (response) {
        $("#nationalTeams").html(response);
      },
      error: function (response) {
        err.innerHTML = response.responseText;
      },
    });
  }); //endof print selected nation

  //fills #egyebMezekDiv with content by post
  $("#egyebMezekDiv").ready(function () {
    $.post("php/egyebMezekDiv.php", { egyeb: 1 }, function (adat) {
      $("#egyebMezekDiv").html(adat);
    });
  });

  //print selected egyebMEzek data by egyebMezekDiv.php
  $(document).on("click", ".data-egyebMezek", function () {
    const eId = $(this).attr("data-EgyebMezekID");
    const err = document.getElementById("egyebMezekTeam");
    $.ajax({
      url: "php/egyebMezekShow.php",
      method: "POST",
      dataType: "text",
      data: { eId: eId },
      success: function (response) {
        $("#egyebMezekTeam").html(response);
      },
      error: function (response) {
        err.innerHTML = response.responseText;
      },
    });
  }); //endof print selected egyebMezek

  //európa-liga DIV is filled with data after loading
  $("#euLigaDiv").ready(function () {
    $.post("php/euLigaDiv.php", { eu: 1 }, function (adat) {
      $("#euLigaDiv").html(adat);
    });
  });

  //print selected euLigaMEzek data by euLigaDiv.php
  $(document).on("click", ".data-euLigaMezek", function () {
    const euId = $(this).attr("data-euLigaMezekID");
    const err = document.getElementById("euLigaTeam");
    $.ajax({
      url: "php/euLigaShow.php",
      method: "POST",
      dataType: "text",
      data: { euId: euId },
      success: function (response) {
        $("#euLigaTeam").html(response);
      },
      error: function (response) {
        err.innerHTML = response.responseText;
      },
    });
  }); //endof print selected euLiga

  $("#otherLigaDiv").ready(function () {
    $.post("php/otherLigaDiv.php", { other: 1 }, function (adat) {
      $("#otherLigaDiv").html(adat);
    });
  });

  //print selected otherLigaMEzek data by euLigaDiv.php
  $(document).on("click", ".data-otherLigaMezek", function () {
    const otherId = $(this).attr("data-otherLigaMezekID");
    const err = document.getElementById("otherLigaTeam");
    $.ajax({
      url: "php/otherLigaShow.php",
      method: "POST",
      dataType: "text",
      data: { otherId: otherId },
      success: function (response) {
        $("#otherLigaTeam").html(response);
      },
      error: function (response) {
        err.innerHTML = response.responseText;
      },
    });
  }); //endof print selected otherLiga
});
