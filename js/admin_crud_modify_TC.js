$(function () {
  //prints out modT-league-select
  $(document).on("change", "#modT-League-select", function () {
    const valLeague = $(this).val();
    const categorySelectT = document.getElementById("categorySelectT");
    const teamSelectT = document.getElementById("teamSelectT");
    $.post(
      "php/admin_crud/printCategorySelect_modT.php",
      { valLeague: valLeague },
      function (res) {
        categorySelectT.innerHTML = res;
      }
    );
    $.post(
      "php/admin_crud/printTeamSelect_modT.php",
      { reset: "reset" },
      function (res) {
        teamSelectT.innerHTML = res;
      }
    );
    //if you change a league, after 50milliseconds, read out the team's id from select field
    setTimeout(function () {
      $.ajax({
        url: "php/admin_crud/printAktTeamDetails.php",
        method: "post",
        data: { reset: "reset" },
        dataType: "JSON",
        success: function (res) {
          const inputCsapatnev = document.getElementById("teamName");
          const inputCsapatvaros = document.getElementById("cityName");
          inputCsapatnev.value = res.csapat;
          inputCsapatvaros.value = res.varos;
        },
        error: function (res) {
          console.log(res);
        },
      });
    }, 50);
  }); //endof newM-league-select

  //prints out newM-Category-select
  $(document).on("change", "#modT-Cat-select", function () {
    const valCat = $(this).val();
    const teamSelectT = document.getElementById("teamSelectT");

    $.post(
      "php/admin_crud/printTeamSelect_modT.php",
      { valCat: valCat },
      function (res) {
        teamSelectT.innerHTML = res;
      }
    );
    //if you change a category, after 50milliseconds, read out the team's id from select field
    setTimeout(function () {
      const idTeam = $("#modT-Team-select").val();
      $.ajax({
        url: "php/admin_crud/printAktTeamDetails.php",
        method: "post",
        data: { idTeam, idTeam },
        dataType: "JSON",
        success: function (res) {
          const inputCsapatnev = document.getElementById("teamName");
          const inputCsapatvaros = document.getElementById("cityName");
          inputCsapatnev.value = res.csapat;
          inputCsapatvaros.value = res.varos;
        },
        error: function (res) {
          console.log(res);
        },
      });
    }, 50);
  }); //endof newM-league-select

  $(document).on("change", "#modT-Team-select", function () {
    const idTeam = $(this).val();
    $.ajax({
      url: "php/admin_crud/printAktTeamDetails.php",
      method: "post",
      data: { idTeam, idTeam },
      dataType: "JSON",
      success: function (res) {
        const inputCsapatnev = document.getElementById("teamName");
        const inputCsapatvaros = document.getElementById("cityName");
        inputCsapatnev.value = res.csapat;
        inputCsapatvaros.value = res.varos;
      },
      error: function (res) {
        console.log(res);
      },
    });
  });

  //button resets
  $(document).on("click", "#resetT", function () {
    location.reload();
  });
  $(document).on("click", "#resetC", function () {
    location.reload();
  }); //endof resets

  $(document).on("submit", "#modT-form", function (e) {
    e.preventDefault();
    const idTeam = $("#modT-Team-select").val().trim();
    const newTName = $("#teamName").val().trim();
    const newTCity = $("#cityName").val().trim();

    const err = document.getElementById("errorVanT");
    const succ = document.getElementById("successVanT");
    var errorExists = false;
    var errorMSG = "";
    if (idTeam < 0) {
      errorMSG += "A megadott csapat nem létezik. <br>";
      errorExists = true;
    }
    if (newTName.length < 2) {
      errorMSG += "A csapatnév túl rövid! (min. 2 karakter) <br>";
      errorExists = true;
    }
    if (newTName.length > 100) {
      errorMSG += "A csapatnév túl hosszú! (max. 100 karakter) <br>";
      errorExists = true;
    }
    if (newTCity.length > 100) {
      errorMSG += "A városnév túl hosszú! <br>";
      errorExists = true;
    }

    if (errorExists == false) {
      $.ajax({
        url: "php/admin_crud/modifyT.php",
        method: "post",
        data: { idTeam: idTeam, newTName: newTName, newTCity: newTCity },
        dataType: "JSON",
        success: function (res) {
          if (res.error == false) {
            succ.innerHTML =
              "Sikeresen módosítottam az adatokat! :)<br>" + res.successMessage;
            succ.style.display = "block";
            err.innerHTML = "";
            err.style.display = "none";
          } else {
            err.innerHTML = res.errorMessage;
            err.style.display = "block";
            succ.innerHTML = "";
            succ.style.display = "none";
          }
        },
        error: function (res) {
          console.log(res.responseJSON);
          err.innerHTML = "Valami hiba történt!(JS) " + res.responseText;
          err.style.display = "block";
          succ.innerHTML = "";
          succ.style.display = "none";
        },
      });
    } else {
      err.innerHTML = errorMSG;
      err.style.display = "block";
      succ.innerHTML = "";
      succ.style.display = "none";
    }
  }); //endof submit #modT-form
}); //endof ready
