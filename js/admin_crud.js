$(document).ready(function () {
  //for test
  $(document).on("change", "#newT-Cat-select", function () {
    console.log($(this).val());
  });

  //submit event on new team (post to newTC.php)
  $(document).on("submit", "#newT-form", function (event) {
    event.preventDefault();

    const err = document.getElementById("errorVanT");
    const succ = document.getElementById("successVanT");
    err.innerHTML = "";
    succ.innerHTML = "";
    err.style.display = "none";
    succ.style.display = "none";

    var errMSG = "";
    var errExists = false;
    const cat = document.getElementById("newT-Cat-select").value.trim();
    const Tname = document.getElementById("teamName").value.trim();
    const cityName = document.getElementById("cityName").value.trim();

    if (cat < 0) {
      errMSG += "Hiba, ilyen kategória nincs! ";
      errExists = true;
    }
    if (Tname.length < 2 || Tname.length > 100) {
      errMSG += "Hiba, a csapatnév nem megfelelő hosszú! ";
      errExists = true;
    }
    if (cityName.length > 100) {
      errMSG += "Hiba, a város neve túl hosszú!";
      errExists = true;
    }

    if (!errExists) {
      $.ajax({
        url: "php/admin_crud/newTC.php",
        method: "POST",
        dataType: "text",
        data: { cat: cat, Tname: Tname, cityName: cityName },
        success: function () {
          console.log("success ág");
          succ.innerHTML = "Sikeres bevitel: " + Tname + " !";
          succ.style.display = "block";
        },
        error: function (res) {
          console.log("error ág");
          const resJSON = JSON.parse(res);
        },
      });
    } else {
      err.innerHTML = errMSG;
      err.style.display = "block";
    }
  }); //endof new team post

  //reset on insert teams
  $(document).on("click", "#resetT", function () {
    const err = document.getElementById("errorVanT");
    const succ = document.getElementById("successVanT");
    err.innerHTML = "";
    succ.innerHTML = "";
    err.style.display = "none";
    succ.style.display = "none";
    document.getElementById("newT-Cat-select").value = "49";
    document.getElementById("teamName").value = "";
    document.getElementById("cityName").value = "";
  });
  //reset on insert category
  $(document).on("click", "#resetC", function () {
    const err = document.getElementById("errorVanC");
    const succ = document.getElementById("successVanC");
    err.innerHTML = "";
    succ.innerHTML = "";
    err.style.display = "none";
    succ.style.display = "none";
    document.getElementById("newC-Liga-select").value = "2";
    document.getElementById("catName").value = "";
  });
}); //endof ready()
