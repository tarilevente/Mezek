$(document).ready(function () {
  //index.php loading counter

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
      success: function (response) {
        const resJSON = JSON.parse(response);
        if (resJSON.error) {
          $("#nemzetiDiv").html(resJSON.errMsg);
          console.log(resJSON.errMsg);
        } else {
          $("#nemzetiDiv").html(resJSON.html);
        }
      },
      error: function (response) {
        const resJSON = JSON.parse(response.responseText);
        if (resJSON.errorCode == 78691) {
          console.log("Error code: 78691, no POST ARRIVED");
        }
        resJSON.errorCode == 78694
          ? console.log("Error code: 78694, no data in db table")
          : "";
        $("#nemzetiDiv").html(resJSON.errMsg);
      },
    });
  });

  //print selected national data by nemzetiDiv.php
  $(document).on("click", ".data-national", function () {
    const nId = $(this).attr("data-nationalID");
    const err = document.getElementById("nationalTeams");
    $.ajax({
      url: "php/nemzetiTeamsShow.php",
      method: "POST",
      dataType: "JSON",
      data: { nId: nId },
      success: function (response) {
        $("#nationalTeams").html(response.html);
      },
      error: function (response) {
        response.responseJSON.errorCode == 78692
          ? console.log("Error code: 78692, No post arrived")
          : "";
        err.innerHTML = response.responseJSON.errMsg;
      },
    });
  }); //endof print selected nation

  //fills #egyebMezekDiv with content by post
  $("#egyebMezekDiv").ready(function () {
    $.ajax({
      url: "php/egyebMezekDiv.php",
      method: "POST",
      dataType: "JSON",
      data: { egyeb: 1 },
      success: function (response) {
        $("#egyebMezekDiv").html(response.html);
      },
      error: function (response) {
        const resJSON = response.responseJSON;
        if (resJSON.errorCode == 56456) {
          console.log("Error code: 56456, no POST ARRIVED");
        } else if (resJSON.errorCode == 56459) {
          console.log("Error code: 56459, database no contains properly data");
        }
        $("#egyebMezekDiv").html(resJSON.errMsg);
      },
    });
  });

  //print selected egyebMEzek data by egyebMezekDiv.php
  $(document).on("click", ".data-egyebMezek", function () {
    const eId = $(this).attr("data-EgyebMezekID");
    const err = document.getElementById("egyebMezekTeam");
    $.ajax({
      url: "php/egyebMezekShow.php",
      method: "POST",
      dataType: "JSON",
      data: { eId: eId },
      success: function (response) {
        if (response.error == false) {
          $("#egyebMezekTeam").html(response.html);
        }
      },
      error: function (response) {
        response.responseJSON.errorCode == 56457
          ? console.log("Error code: 56457, No post arrived")
          : "";
        err.innerHTML = response.responseJSON.errMsg;
      },
    });
  }); //endof print selected egyebMezek

  //európa-liga DIV is filled with data after loading
  $("#euLigaDiv").ready(function () {
    $.ajax({
      url: "php/euLigaDiv.php",
      method: "POST",
      dataType: "JSON",
      data: { eu: 1 },
      success: function (response) {
        $("#euLigaDiv").html(response.html);
      },
      error: function (response) {
        const resJSON = response.responseJSON;
        if (resJSON.errorCode == 26481) {
          console.log("Error code: 26481, no POST ARRIVED");
        } else if (resJSON.errorCode == 26484) {
          console.log("Error code: 26484, database no contains properly data");
        }
        $("#euLigaDiv").html(resJSON.errMsg);
      },
    });
  });

  //print selected euLigaMEzek data by euLigaDiv.php
  $(document).on("click", ".data-euLigaMezek", function () {
    const euId = $(this).attr("data-euLigaMezekID");
    const err = document.getElementById("euLigaTeam");
    $.ajax({
      url: "php/euLigaShow.php",
      method: "POST",
      dataType: "JSON",
      data: { euId: euId },
      success: function (response) {
        $("#euLigaTeam").html(response.html);
      },
      error: function (response) {
        const resErr = response.responseJSON;
        if (resErr.errorCode == 26482) {
          console.log("Error code: 26482, no POST ARRIVED");
        } else if (resErr.errorCode == 26483) {
          console.log("Error code: 26483, database no contains properly data");
        }
        err.innerHTML = resErr.errMsg;
      },
    });
  }); //endof print selected euLiga

  $("#otherLigaDiv").ready(function () {
    $.ajax({
      url: "php/otherLigaDiv.php",
      method: "POST",
      dataType: "JSON",
      data: { other: 1 },
      success: function (response) {
        $("#otherLigaDiv").html(response.html);
      },
      error: function (response) {
        const resJSON = response.responseJSON;
        if (resJSON.errorCode == 12674) {
          console.log("Error code: 12674, no POST ARRIVED");
        } else if (resJSON.errorCode == 12677) {
          console.log("Error code: 12677, database no contains properly data");
        }
        $("#otherLigaDiv").html(resJSON.errMsg);
      },
    });
  });

  //print selected otherLigaMEzek data by euLigaDiv.php
  $(document).on("click", ".data-otherLigaMezek", function () {
    const otherId = $(this).attr("data-otherLigaMezekID");
    const err = document.getElementById("otherLigaTeam");
    $.ajax({
      url: "php/otherLigaShow.php",
      method: "POST",
      dataType: "JSON",
      data: { otherId: otherId },
      success: function (response) {
        $("#otherLigaTeam").html(response.html);
      },
      error: function (response) {
        const resErr = response.responseJSON;
        if (resErr.errorCode == 12675) {
          console.log("Error code: 12675, no POST ARRIVED");
        } else if (resErr.errorCode == 12676) {
          console.log("Error code: 12676, database no contains properly data");
        }
        err.innerHTML = resErr.errMsg;
      },
    });
  }); //endof print selected otherLiga

  //this method will show the selected pic in bootstrap "modal" //
  $(document).on("click", ".picToShow", function () {
    const picId = $(this).attr("data-picid");
    const err = document.getElementById("modalContent");
    $.ajax({
      url: "php/picZoomed.php",
      method: "POST",
      dataType: "JSON",
      data: { picId: picId },
      success: function (response) {
        $("#modalContent").html(response.html);
      },
      error: function (response) {
        const resErr = response.responseJSON;
        if (resErr.errorCode == 87420) {
          console.log("Error code: 87420, no POST ARRIVED");
        } else if (resErr.errorCode == 87421) {
          console.log(
            "Error code: 87421, database no contains properly data (MEZ)"
          );
        } else if (resErr.errorCode == 87422) {
          console.log(
            "Error code: 87422, database no contains properly data (PIC)"
          );
        } else if (resErr.errorCode == 87423) {
          console.log(
            "Error code: 87423, database no contains properly data (Csapat)"
          );
        }

        err.innerHTML = resErr.errMsg;
      },
    });
  }); //end of show selected pic

  //email validation method
  function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }

  function makeid(length) {
    var result = "";
    var characters =
      "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
  }

  const err = document.getElementsByClassName("error")[0];
  const succ = document.getElementsByClassName("success")[0];

  err.innerHTML = "";
  succ.innerHTML = "";
  err.style.display = "none";
  succ.style.display = "none";
  //email function
  $(document).on("submit", "#emailForm", function (e) {
    e.preventDefault();
    //js gets the data from platform //egyelőre nem.
    const fromName = document.getElementById("name").value.trim();
    const fromEmail = document.getElementById("email").value.trim();
    const subject = document.getElementById("subject").value.trim();
    const content = document.getElementById("content").value.trim();

    var errMsg = "";
    var succMsg = "";

    var mehet = true;
    //validation of data
    if (fromName.length < 3) {
      errMsg += "Név: minimum 3 karakter! <br>";
      mehet = false;
    }
    if (subject.length < 3) {
      errMsg += "Tárgy: minimum 3 karakter! <br>";
      mehet = false;
    }
    if (content.length < 5) {
      errMsg += "Üzenet: minimum 5 karakter! <br>";
      mehet = false;
    }
    if (!validateEmail(fromEmail)) {
      errMsg += "Az email cím nem megfelelő formátumú! ";
      mehet = false;
    }

    //send data to a php file to validation toward,
    //and send an email
    if (mehet) {
      $.ajax({
        url: "sendmail.php",
        method: "POST",
        dataType: "text",
        data: {
          fromName: fromName,
          fromEmail: fromEmail,
          subject: subject,
          content: content,
        },
        success: function (res) {
<<<<<<< HEAD
          console.log("js success " + res);
=======
          console.log("js success" + res);
>>>>>>> 90174275bccca1de6d599af1eef761b15517366e
          const resJSON = JSON.parse(res);
          console.log(resJSON.html);
          err.style.display = "none";
          err.innerHTML = "";
          succ.innerHTML = "Az email-t sikeresen elküldtem! :)";
          succ.style.display = "block";
        },
        error: function (res) {
          console.log("errorág " + res.responseText);
          const resJSON = JSON.parse(res.responseText);
          succ.style.display = "none";
          succ.innerHTML = "";
          //for developers
          console.log("(Error, no post, code is: " + resJSON.errorCode + " )");
          //for users
          err.innerHTML = resJSON.errorMsg;
          err.style.display = "block";
        },
      });
    } else {
      //if occurs a problem, we'll have a message back, with error
      err.style.display = "block";
      err.innerHTML = errMsg;
    }
  });

  //Delete the content of the email
  $(document).on("click", "#tartalomTorlese", function () {
    err.innerHTML = "";
    succ.innerHTML = "";
    err.style.display = "none";
    succ.style.display = "none";

    const fromName = document.getElementById("name");
    const fromEmail = document.getElementById("email");
    const subject = document.getElementById("subject");
    const content = document.getElementById("content");
    fromName.value = "";
    fromEmail.value = "";
    subject.value = "";
    content.value = "";
  }); //endof deleting the content of the email form
}); //endof ready()
