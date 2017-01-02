$(document).on('click', '.ticket-submit', function(){
    var buttonID = $(this).attr('id');
    sendToServer(buttonID);
});

function sendToServer(buttonID) {
  var data = 'id=' + buttonID;
  
  $.ajax({
    url: 'http://46.101.250.32/reservation.php',
    type: "POST",
    data: { id: buttonID },
    cache: false,
    success: function (html) {
      alert("Success it seems..");
    }
  });
}
