$(document).ready(function () {
  //for test
  $(document).on("change", "#newT-Cat-select", function () {
    console.log($(this).val());
  });

  //submit event on new team (post to newT.php)
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
    var cityName = document.getElementById("cityName").value.trim();
    if (cityName.length < 1) {
      cityName = "";
    }

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
        url: "php/admin_crud/newT.php",
        method: "POST",
        dataType: "text",
        data: { cat: cat, Tname: Tname, cityName: cityName },
        success: function (res) {
          err.innerHTML = "";
          err.style.display = "none";
          succ.innerHTML = "Sikeres bevitel!";
          succ.style.display = "block";
        },
        error: function (res) {
          const resJSON = JSON.parse(res.responseText);
          if (resJSON.errorCode == 75200) {
            console.log("no post, error code: 75200");
            err.innerHTML = resJSON.errorMsg;
            err.style.display = "block";
            succ.innerHTML = "";
            succ.style.display = "none";
          }
          if (resJSON.errorCode == 75201) {
            console.log("wrong category: 75201");
            err.innerHTML = resJSON.errorMsg;
            err.style.display = "block";
            succ.innerHTML = "";
            succ.style.display = "none";
          }
          if (resJSON.errorCode == 75202) {
            console.log("wrong teamname, error code: 75202");
            err.innerHTML = resJSON.errorMsg;
            err.style.display = "block";
            succ.innerHTML = "";
            succ.style.display = "none";
          }
          if (resJSON.errorCode == 75203) {
            console.log("empty category, or empty teamname, error code: 75203");
            err.innerHTML = resJSON.errorMsg;
            err.style.display = "block";
            succ.innerHTML = "";
            succ.style.display = "none";
          }
          if (resJSON.errorCode == 75204) {
            console.log("cityname is too long, error code: 75204");
            err.innerHTML = resJSON.errorMsg;
            err.style.display = "block";
            succ.innerHTML = "";
            succ.style.display = "none";
          }
          if (resJSON.errorCode == 75205) {
            console.log("team already exists, error code: 75205");
            err.innerHTML = resJSON.errorMsg;
            err.style.display = "block";
            succ.innerHTML = "";
            succ.style.display = "none";
          }
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
  }); //endof reset

  //submit event on new category (post to newC.php)
  $(document).on("submit", "#newC-form", function (event) {
    event.preventDefault();

    const err = document.getElementById("errorVanC");
    const succ = document.getElementById("successVanC");
    err.innerHTML = "";
    succ.innerHTML = "";
    err.style.display = "none";
    succ.style.display = "none";

    var errMSG = "";
    var errExists = false;
    const liga = document.getElementById("newC-Liga-select").value.trim();
    const Cname = document.getElementById("catName").value.trim();
    if (liga < 0) {
      errMSG += "Hiba, ilyen liga nincs! ";
      errExists = true;
    }
    if (Cname.length < 2 || Cname.length > 100) {
      errMSG += "Hiba, a kategórianév nem megfelelő hosszúságú! ";
      errExists = true;
    }

    if (!errExists) {
      $.ajax({
        url: "php/admin_crud/newC.php",
        method: "POST",
        dataType: "text",
        data: { liga: liga, Cname: Cname },
        success: function (res) {
          err.innerHTML = "";
          err.style.display = "none";
          succ.innerHTML = "Sikeres bevitel " + Cname + " !";
          succ.style.display = "block";
        },
        error: function (res) {
          console.log(res.responseText);
          const resJSON = JSON.parse(res.responseText);
          if (resJSON.errorCode == 76100) {
            console.log("no post, error code: 76100");
            err.innerHTML = resJSON.errorMsg;
            err.style.display = "block";
            succ.innerHTML = "";
            succ.style.display = "none";
          }
          if (resJSON.errorCode == 76101) {
            console.log("no categoryName or no liga, error code: 76101");
            err.innerHTML = resJSON.errorMsg;
            err.style.display = "block";
            succ.innerHTML = "";
            succ.style.display = "none";
          }
          if (resJSON.errorCode == 76102) {
            console.log("liga not exists, error code: 76102");
            err.innerHTML = resJSON.errorMsg;
            err.style.display = "block";
            succ.innerHTML = "";
            succ.style.display = "none";
          }
          if (resJSON.errorCode == 76103) {
            console.log("catName too shor or too long, error code: 76103");
            err.innerHTML = resJSON.errorMsg;
            err.style.display = "block";
            succ.innerHTML = "";
            succ.style.display = "none";
          }
          if (resJSON.errorCode == 76104) {
            console.log("category already exists, error code: 76104");
            err.innerHTML = resJSON.errorMsg;
            err.style.display = "block";
            succ.innerHTML = "";
            succ.style.display = "none";
          }
        },
      });
    } else {
      err.innerHTML = errMSG;
      err.style.display = "block";
    }
  }); //endof new team post

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
  }); //endof reset
}); //endof ready()
