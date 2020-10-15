$(document).ready(function () {
  $.getJSON({
    url: "../leave/get.php",
    method: "GET",
    success: function (data) {
      var id = [];
      var days = [];

      for (var i in data) {
        id.push("leave " + data[i].leaveId);
        days.push(data[i].No_Of_Days);
      }

      var chartData = {
        labels: id,
        datasets: [
          {
            label: "Leave",
            backgroundColor: "rgba(200,200,200,0.75)",
            borderColor: "rgba(200,200,200,0.75)",
            hoverBackgroundColor: "rgba(200,200,200,1)",
            hoverBorderColor: "rgba(200,200,200,1)",
            data: days,
          },
        ],
      };

      var ctx = $("#myCanvas");

      var bargraph = new Chart(ctx, {
        type: "bar",
        data: chartData,
      });
    },
    error: function (data) {
      console.log(data);
    },
  });
});
