$(function () {
  //prints out modT-league-select
  $(document).on("change", "#modT-League-select", function () {
    const valLeague = $(this).val();
    const categorySelectT = $("#categorySelectT")[0];
    const teamSelectT = $("#teamSelectT")[0];
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
          const inputCsapatnev = $("#teamName");
          const inputCsapatvaros = $("#cityName");
          inputCsapatnev.val(res.csapat);
          inputCsapatvaros.val(res.varos);
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
    const teamSelectT = $("#teamSelectT")[0];

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
          const inputCsapatnev = $("#teamName");
          const inputCsapatvaros = $("#cityName");
          inputCsapatnev.val(res.csapat);
          inputCsapatvaros.val(res.varos);
        },
        error: function (res) {
          console.log(res);
        },
      });
    }, 50);
  }); //endof newM-league-select

  //in case of modify teamSelect, prints out the proper team details
  $(document).on("change", "#modT-Team-select", function () {
    const idTeam = $(this).val();
    $.ajax({
      url: "php/admin_crud/printAktTeamDetails.php",
      method: "post",
      data: { idTeam, idTeam },
      dataType: "JSON",
      success: function (res) {
        const inputCsapatnev = $("#teamName");
        const inputCsapatvaros = $("#cityName");
        inputCsapatnev.val(res.csapat);
        inputCsapatvaros.val(res.varos);
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

    const err = $("#errorVanT")[0];
    const succ = $("#successVanT")[0];
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
          err.innerHTML = "Valami hiba történt! " + res.responseText;
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

  //================================  Category Modify ==============================
  //league select changed
  $(document).on("change", "#modC-League-select", function () {
    const valLeague = $(this).val();
    const categorySelectC = $("#categorySelectC")[0];
    $.post(
      "php/admin_crud/printCategorySelect_modC.php",
      { valLeague: valLeague },
      function (res) {
        categorySelectC.innerHTML = res;
      }
    );
    //if you change a league, after 50milliseconds, read out the cat's id from select field
    setTimeout(function () {
      const idCat = $("#modC-Cat-select").val();
      $.ajax({
        url: "php/admin_crud/printAktCategoryDetails.php",
        method: "post",
        data: { idCat, idCat },
        dataType: "JSON",
        success: function (res) {
          const inputCatnev = $("#catName");
          inputCatnev.val(res.cat);
        },
        error: function (res) {
          console.log(res);
        },
      });
    }, 50);
  }); //endof newC-league-select

  //print out the categoryname to input:text
  $(document).on("change", "#modC-Cat-select", function () {
    const idCat = $(this).val();
    $.ajax({
      url: "php/admin_crud/printAktCategoryDetails.php",
      method: "post",
      data: { idCat, idCat },
      dataType: "JSON",
      success: function (res) {
        const inputCatnev = $("#catName");
        inputCatnev.val(res.cat);
      },
      error: function (res) {
        console.log(res);
      },
    });
  }); //endof print inputValue

  //submit catForm, upload data
  $(document).on("submit", "#modC-form", function (e) {
    e.preventDefault();
    const idCat = $("#modC-Cat-select").val().trim();
    const newCName = $("#catName").val().trim();

    const err = $("#errorVanC")[0];
    const succ = $("#successVanC")[0];
    var errorExists = false;
    var errorMSG = "";
    if (idCat < 0) {
      errorMSG += "A megadott kategória nem létezik. <br>";
      errorExists = true;
    }
    if (newCName.length < 2) {
      errorMSG += "A kategórianév túl rövid! (min. 2 karakter) <br>";
      errorExists = true;
    }
    if (newCName.length > 100) {
      errorMSG += "A kategórianév túl hosszú! (max. 100 karakter) <br>";
      errorExists = true;
    }

    if (errorExists == false) {
      $.ajax({
        url: "php/admin_crud/modifyC.php",
        method: "post",
        data: { idCat: idCat, newCName: newCName },
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
          alert(res.responseText);
          err.innerHTML = "Valami hiba történt!(js) " + res.responseJSON;
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
  }); //endof submit #modC-form

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.getElementsByClassName("needs-validation");
  // Loop over them and prevent submission
  var validation = Array.prototype.filter.call(forms, function (form) {
    form.addEventListener(
      "submit",
      function (event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add("was-validated");
      },
      false
    );
  }); //endof validate form bootstrap
}); //endof ready
