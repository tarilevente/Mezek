$(function () {
  // modifyM-league-select
  $(document).on("change", "#modifyM-League-select", function () {
    const valLeague = $(this).val();
    const categorySelect = document.getElementById("categorySelect");
    $.post(
      "php/admin_crud/printCategorySelect_modifyM.php",
      { valLeague: valLeague },
      function (res) {
        categorySelect.innerHTML = res;
      }
    );
    $.post(
      "php/admin_crud/printTeamSelect_modifyM.php",
      { reset: "reset" },
      function (res) {
        teamSelect.innerHTML = res;
      }
    );
    //if you change a league, after 50milliseconds, read out the team's id from select field
    setTimeout(function () {
      const valCat = $("#modifyM-Cat-select").val();
      $.ajax({
        url: "php/admin_crud/printTeamSelect_modifyM.php",
        method: "post",
        data: { valCat: valCat },
        dataType: "text",
        success: function (res) {
          teamSelect.innerHTML = res;
        },
        error: function (res) {
          console.log("error " + res.responseText);
        },
      });
    }, 50);

    //print the team, or remove the last selection
    setTimeout(function () {
      const idTeam = $("#modifyM-Team-select").val();
      const teamCards = document.getElementById("teamCards");
      $.ajax({
        url: "php/admin_crud/printTeamCards.php",
        method: "POST",
        data: { idTeam: idTeam },
        dataType: "JSON",
        success: function (res) {
          if (res.error == false) {
            teamCards.innerHTML = res.html;
            // console.log(idTeam);
          } else {
            teamCards.innerHTML = res.errorMsg;
            // console.log(res);
          }
        },
        error: function (res) {
          console.log(res);
        },
      });
    }, 150);

    //hide the modifyForm
    $("#ModifyMezID")[0].innerHTML = "";
  }); //endof modifyM-league-select

  //prints out modifyM-Category-select
  $(document).on("change", "#modifyM-Cat-select", function () {
    const valCat = $(this).val();
    // console.log(valCat);
    const teamSelect = document.getElementById("teamSelect");
    $.post(
      "php/admin_crud/printTeamSelect_modifyM.php",
      { valCat: valCat },
      function (res) {
        teamSelect.innerHTML = res;
      }
    );
    //print the team, or remove the last selection
    setTimeout(function () {
      const idTeam = $("#modifyM-Team-select").val();
      const teamCards = document.getElementById("teamCards");
      $.ajax({
        url: "php/admin_crud/printTeamCards.php",
        method: "POST",
        data: { idTeam: idTeam },
        dataType: "JSON",
        success: function (res) {
          if (res.error == false) {
            teamCards.innerHTML = res.html;
            // console.log(idTeam);
          } else {
            teamCards.innerHTML = res.errorMsg;
            console.log(res);
          }
        },
        error: function (res) {
          console.log(res);
        },
      });
    }, 150);
    //hide the modifyForm
    $("#ModifyMezID")[0].innerHTML = "";
  }); //endof modifyM-category-select

  //print selected teams cards to choose a Mez
  $(document).on("change", "#modifyM-Team-select", function () {
    const idTeam = $(this).val();
    const teamCards = document.getElementById("teamCards");
    $.ajax({
      url: "php/admin_crud/printTeamCards.php",
      method: "POST",
      data: { idTeam: idTeam },
      dataType: "JSON",
      success: function (res) {
        if (res.error == false) {
          teamCards.innerHTML = res.html;
          // console.log(idTeam);
        } else {
          teamCards.innerHTML = res.errorMsg;
          console.log(res);
        }
      },
      error: function (res) {
        console.log(res);
      },
    });
    //hide the modifyForm
    $("#ModifyMezID").innerHTML = "";
  }); //endof teamselect

  var aktLoaded = null;
  //.modifyMez : Shows the modifyForm.
  //read out the data-id of the selected Mez
  $(document).on("click", ".ModifyMezCLASS", function () {
    const idMez = $(this).data("id");
    aktLoaded = idMez;
    //hide the modifyForm
    const formHtml = $("#ModifyMezID")[0];
    formHtml.innerHTML = "";
    $.get("printModifyForm.php", { idMez: idMez }, function (data) {
      formHtml.innerHTML = data;
    });
  }); //endof show the form

  //reset to the actual datas
  $(document).on("click", "#resetMM", function () {
    //hide the modifyForm
    const formHtml = $("#ModifyMezID")[0];
    formHtml.innerHTML = "";
    $.get("printModifyForm.php", { idMez: aktLoaded }, function (data) {
      formHtml.innerHTML = data;
    });
  });

  //submit

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
}); //endof ready()
