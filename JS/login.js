$(document).ready(function () {
  $("#loginForm").submit(function (event) {
    event.preventDefault();

    let email = $("#email").val().trim();
    let password = $("#password").val();

    $.ajax({
      url: "php/login.php",

      type: "POST",

      dataType: "json",

      data: {
        email: email,
        password: password,
      },

      success: function (response) {
        if (response.success) {
          $("#message").html(
            '<div class="alert alert-success">' + response.message + "</div>",
          );

          setTimeout(function () {
            window.location.href = "index.html";
          }, 1000);
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
            "Something went wrong." +
            "</div>",
        );
      },
    });
  });
});
