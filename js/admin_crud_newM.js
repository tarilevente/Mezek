$(document).ready(function () {
  //https://jsfiddle.net/bootstrapious/8w7a50n2/
  //display pics in form newM-form.fa-php
  var input = document.getElementById("upload");
  var infoArea = document.getElementById("upload-label");
  var input2 = document.getElementById("upload2");
  var infoArea2 = document.getElementById("upload-label2");
  var input3 = document.getElementById("upload3");
  var infoArea3 = document.getElementById("upload-label3");

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

  //prints out newM-league-select
  $(document).on("change", "#newM-league-select", function () {
    const valLeague = $(this).val();
    const categorySelect = document.getElementById("categorySelect");
    $.post(
      "php/admin_crud/printCategorySelect_newM.php",
      { valLeague: valLeague },
      function (res) {
        categorySelect.innerHTML = res;
      }
    );
    $.post(
      "php/admin_crud/printTeamSelect_newM.php",
      { reset: "reset" },
      function (res) {
        teamSelect.innerHTML = res;
      }
    );
  }); //endof newM-league-select

  //prints out newM-Category-select
  $(document).on("change", "#newM-cat-select", function () {
    const valCat = $(this).val();
    const teamSelect = document.getElementById("teamSelect");
    $.post(
      "php/admin_crud/printTeamSelect_newM.php",
      { valCat: valCat },
      function (res) {
        teamSelect.innerHTML = res;
      }
    );
  }); //endof newM-category-select

  //reset the nemMez form
  $(document).on("click", "#resetM", function () {
    location.reload();
  }); //endof reset

  //upload the new Mez
  $(document).on("submit", "#newM-form", function (e) {
    e.preventDefault();
    // uploadButton.innerHTML = 'Uploading...';
    const err = document.getElementById("errorVanM");
    const succ = document.getElementById("successVanM");
    err.innerHTML = "";
    succ.innerHTML = "";
    err.style.display = "none";
    succ.style.display = "none";

    var errMSG = "";
    var errExists = false;

    const csapat = document.getElementById("newM-team-select").value;
    const years = document.getElementById("newM-years").value.trim();
    const type = document.getElementById("newM-type-select").value;
    const info = document.getElementById("newM-info").value.trim();

    if (csapat < 0) {
      errMSG += "Ilyen csapat nincs! <br>";
      errExists = true;
    }
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
      fd.append("type", $("#newM-type-select").val());
      fd.append("team", $("#newM-team-select").val());
      for (var value of fd.values()) {
        console.log(value);
      }
      //Allpic send to upload
      $.ajax({
        url: "php/admin_crud/newM.php",
        type: "post",
        data: fd,
        dataType: "JSON",
        contentType: false,
        processData: false,
        success: function (res) {
          if (res.error == false) {
            err.innerHTML = "";
            err.style.display = "none";
            succ.innerHTML = "Sikeres feltöltés!";
            succ.style.display = "block";
          } else {
            succ.innerHTML = "";
            succ.style.display = "none";
            err.innerHTML = res.errorMsg;
            err.style.display = "block";
          }
        },
        error: function (res) {
          console.log(res.responseJSON);
          succ.innerHTML = "";
          succ.style.display = "none";
          err.innerHTML = res.responseJSON;
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
