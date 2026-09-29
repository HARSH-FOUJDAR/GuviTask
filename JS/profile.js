$(document).ready(function () {
  // LOAD PROFILE

  $.ajax({
    url: "php/profile.php",

    type: "GET",

    dataType: "json",

    success: function (response) {
      console.log("Profile Response:", response);

      if (response.success) {
        let user = response.data;

        $("#userId").val(user.id);
        $("#name").val(user.name);
        $("#email").val(user.email);
        $("#Mobile").val(user.Mobile);
        $("#DOB").val(user.DOB);
        $("#DateTime").val(user.DateTime);
      } else {
        alert(response.message);

        window.location.href = "login.html";
      }
    },

    error: function (xhr, status, error) {
      console.log("Error:", error);

      console.log("PHP Response:", xhr.responseText);
    },
  });

  // UPDATE PROFILE

  $("#profileForm").submit(function (event) {
    event.preventDefault();

    let name = $("#name").val().trim();

    let email = $("#email").val().trim();

    let Mobile = $("#Mobile").val().trim();

    let DOB = $("#DOB").val();

    $.ajax({
      url: "php/update-profile.php",

      type: "POST",

      dataType: "json",

      data: {
        name: name,
        email: email,
        Mobile: Mobile,
        DOB: DOB,
      },

      success: function (response) {
        console.log("Update Response:", response);

        if (response.success) {
          $("#message").html(
            '<div class="alert alert-success">' + response.message + "</div>",
          );
        } else {
          $("#message").html(
            '<div class="alert alert-danger">' + response.message + "</div>",
          );
        }
      },

      error: function (xhr, status, error) {
        console.log("HTTP Status:", xhr.status);
        console.log("Status:", status);
        console.log("Error:", error);
        console.log("PHP Response:", xhr.responseText);

        $("#message").html(
          '<div class="alert alert-danger">' +
            "Something went wrong. Check Console." +
            "</div>",
        );
      },
    });
  });
});
