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
    }, 100);

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
    }, 300);

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
    //set the variables of modify pics
    setTimeout(function () {
      kepfelt();
    }, 150);
  }); //endof show the form

  //reset to the actual datas
  $(document).on("click", "#resetMM", function () {
    //hide the modifyForm
    location.reload();
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

  function kepfelt() {
    //reset to the actual datas
    $(document).on("click", "#resetMM", function () {
      //hide the modifyForm
      const formHtml = $("#ModifyMezID")[0];
      formHtml.innerHTML = "";
      $.get("printModifyForm.php", { idMez: aktLoaded }, function (data) {
        formHtml.innerHTML = data;
      });
    });
    //Kiírja, hogy null-nak nem tudja kivenni az értékét, valahogy meg kell oldani
    //kepfeltoltes
    var input = document.getElementById("uploadMod");
    var infoArea = document.getElementById("upload-labelMod");
    var input2 = document.getElementById("uploadMod2");
    var infoArea2 = document.getElementById("upload-labelMod2");
    var input3 = document.getElementById("uploadMod3");
    var infoArea3 = document.getElementById("upload-labelMod3");

    input.addEventListener("change", showFileName1);
    function showFileName1(event) {
      var input = event.srcElement;
      var fileName = input.files[0].name;
      infoArea.textContent = fileName;
    }
    input2.addEventListener("change", showFileName2);
    function showFileName2(event) {
      var input2 = event.srcElement;
      var fileName = input2.files[0].name;
      infoArea2.textContent = fileName;
    }
    input3.addEventListener("change", showFileName3);
    function showFileName3(event) {
      var input3 = event.srcElement;
      var fileName = input3.files[0].name;
      infoArea3.textContent = fileName;
    }

    $(document).on("change", ".kepFeltoltes", function () {
      const target = $(this).attr("name");

      if (target == "#imageResult") {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $(target).attr("src", e.target.result);
          };
        }
        reader.readAsDataURL(input.files[0]);
      }
      if (target == "#imageResult2") {
        if (input2.files && input2.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $(target).attr("src", e.target.result);
          };
        }
        reader.readAsDataURL(input2.files[0]);
      }
      if (target == "#imageResult3") {
        if (input3.files && input3.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $(target).attr("src", e.target.result);
          };
        }
        reader.readAsDataURL(input3.files[0]);
      }
    }); //endof kepfeltoltes

    //delete pics --- when loaded, there is no file connected. if you pic a file, it will be input.files[0]!
    //i will check the contents if deletekep==true, means to delete
    var deleteKep2 = false;
    var deleteKep3 = false;
    $(document).on("click", ".deletePicKep2", function () {
      //just make a sign
      deleteKep2 = true;
      const imgRes = document.getElementById("imageResult2");
      $(imgRes).attr("src", "#del");
      $("#uploadMod2").val("");
      infoArea2.textContent = "Kép2 - nem kötelező";
    }); //endof deletePic2
    $(document).on("click", ".deletePicKep3", function () {
      //just make a sign
      deleteKep3 = true;
      const imgRes = document.getElementById("imageResult3");
      $(imgRes).attr("src", "#del");
      $("#uploadMod3").val("");
      infoArea3.textContent = "Kép3 - nem kötelező";
    }); //endof deletePic2

    //update Mez
    $(document).on("submit", "#modM-form", function (e) {
      e.preventDefault();
      // uploadButton.innerHTML = 'Uploading...';
      const err = document.getElementById("errorVanMM");
      const succ = document.getElementById("successVanMM");
      err.innerHTML = "";
      succ.innerHTML = "";
      err.style.display = "none";
      succ.style.display = "none";

      var errMSG = "";
      var errExists = false;

      const years = document.getElementById("modM-Years").value.trim();
      const type = document.getElementById("modM-Type-select").value;
      const info = document.getElementById("modM-Info").value.trim();

      if (type < 0 || type > 4) {
        errMSG += "Ilyen mez típus nincs! <br>";
        errExists = true;
      }
      if (years.length > 100) {
        errMSG += "Évek: max. 100 karakter! <br>";
        errExists = true;
      }
      if (info.length > 255) {
        errMSG += "Info: max. 255 karakter! <br>";
        errExists = true;
      }

      if (!errExists) {
        var fd = new FormData(this);
        fd.append("type", $("#modM-Type-select").val()); //have to append, because basicly <select> is not a form element
        console.log($("#modM-Type-select").val());
        fd.append("idMez", aktLoaded);
        if ($("#imageResult2").attr("src") == "#del") {
          fd.append("kep2Deleted", true);
        }
        if ($("#imageResult3").attr("src") == "#del") {
          fd.append("kep3Deleted", true);
        }
        // for (var value of fd.values()) {
        // console.log(value);
        // }

        $.ajax({
          url: "php/admin_crud/modifyM.php",
          type: "post",
          data: fd,
          dataType: "JSON",
          contentType: false,
          processData: false,
          success: function (res) {
            if (res.error == false) {
              err.innerHTML = "";
              err.style.display = "none";
              succ.innerHTML = res.successMsg;
              succ.style.display = "block";
            } else {
              succ.innerHTML = "";
              succ.style.display = "none";
              err.innerHTML = res.errorMsg;
              err.style.display = "block";
            }
          },
          error: function (res) {
            console.log(res.responseText);
            succ.innerHTML = "";
            succ.style.display = "none";
            err.innerHTML = res.responseText;
            err.style.display = "block";
          },
        }); //endof AJAX
      } else {
        succ.style.display = "none";
        succ.innerHTML = "";
        err.innerHTML = errMSG;
        err.display = "block";
      }
    }); //endof submit
  } //endof set kepfeltoltes function
}); //endof ready()
