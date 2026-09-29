(document).ready(function () {
  $("#logoutBtn").click(function () {
    $.ajax({
      url: "php/logout.php",

      type: "POST",

      dataType: "json",

      success: function (response) {
        if (response.success) {
          window.location.href = "login.html";
        } else {
          alert(response.message);
        }
      },

      error: function (xhr, status, error) {
        console.log("Error:", error);

        console.log("PHP Response:", xhr.responseText);
      },
    });
  });
});
