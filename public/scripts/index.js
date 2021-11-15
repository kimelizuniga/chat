let chatDiv = document.getElementById("chat");
let sendBtn = document.getElementById("sendBtn");
let textArea = document.getElementById("message");

textArea.addEventListener("keyup", function (event) {
  if (event.key == "Enter" && !event.shiftKey) {
    sendBtn.click();
  }
});

$(document).ready(function () {
  setInterval(refreshMessage, 3000);
  function refreshMessage() {
    $.ajax({
      url: "chat.php",
      type: "GET",
      dataType: "html",
      success: function (data) {
        $("#chat").html(data);
      },
      error: function () {
        $("#chat").prepend("Error retrieving new messages..");
      },
    });
  }
});
