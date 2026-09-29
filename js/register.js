$(document).ready(function () {
  $("#registerForm").submit(function (event) {
    event.preventDefault();

    let name = $("#name").val();
    let email = $("#email").val();
    let mobile = $("#Mobile").val();
    let DOB = $("#DOB").val();
    let password = $("#password").val();
    let confirmPassword = $("#confirmPassword").val();

    // Check if passwords match
    if (password !== confirmPassword) {
      $("#message").html(
        '<div class="alert alert-danger">' +
          "Passwords do not match." +
          "</div>",
      );

      return;
    }

    $.ajax({
      url: "php/register.php",

      type: "POST",

      dataType: "json",

      data: {
        name: name,
        email: email,
        Mobile: mobile,
        DOB: DOB,
        password: password,
      },

      success: function (response) {
        if (response.success) {
          $("#message").html(
            '<div class="alert alert-success">' + response.message + "</div>",
          );

          $("#registerForm")[0].reset();
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
      },
    });
  });
});
