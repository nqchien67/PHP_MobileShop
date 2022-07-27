$(document).ready(function () {
  const DateTime = luxon.DateTime;
  const selectDate = $("#selectDate");
  let myChart;
  function createDateArr(dates) {
    let minDate = new Date(dates[0]).getTime();
    let maxDate = new Date(dates[dates.length - 1]).getTime();

    let newDates = [];
    let currentDate = minDate;
    let d;

    while (currentDate <= maxDate) {
      d = new Date(currentDate);
      newDates.push(formatDate(d));
      currentDate += 24 * 60 * 60 * 1000;
    }
    return newDates;
  }

  function renderChart() {
    const data = {
      labels: [],
      datasets: [
        {
          label: "Tổng tiền",
          yAxisID: "price",
          backgroundColor: "rgb(54, 162, 235)",
          borderColor: "rgb(54, 162, 235)",
          data: [],
          tension: 0.1,
        },
        {
          label: "Tổng đơn hàng",
          yAxisID: "total",
          backgroundColor: "rgb(255, 99, 132)",
          borderColor: "rgb(255, 99, 132)",
          data: [],
          tension: 0.1,
        },
      ],
    };

    const config = {
      type: "line",
      data: data,
      options: {
        responsive: true,
        interaction: {
          mode: "index",
          intersect: false,
        },
        stacked: false,
        scales: {
          price: {
            type: "linear",
            position: "left",
            display: true,
            title: {
              display: true,
              text: "Tổng tiền",
            },
            ticks: {
              beginAtZero: true,
              min: 0,
              autoSkip: true,
              autoSkipPadding: 40,
            },
            gridLines: {
              display: true,
            },
          },
          total: {
            type: "linear",
            position: "right",
            display: true,
            title: {
              display: true,
              text: "Tổng đơn hàng",
            },
            ticks: {
              precision: 0,
              beginAtZero: true,
              autoSkip: true,
              autoSkipPadding: 40,
            },
            grid: {
              drawOnChartArea: false,
            },
          },
        },
      },
    };

    myChart = new Chart($("#chart"), config);
  }

  function updateChart(array) {
    let labels = [];
    let price = [];
    let total = [];
    for (let i of array) {
      labels.push(DateTime.fromISO(i["date"]).toLocaleString());
      price.push(i["price"]);
      total.push(i["total"]);
    }
    myChart.data.labels = labels;
    myChart.data.datasets[0].data = price;
    myChart.data.datasets[1].data = total;
    myChart.update();

    $("#price").text(
      "Tổng tiền: " +
        price.reduce(function (a, b) {
          return a + b;
        }).toLocaleString('it-IT', {style : 'currency', currency : 'VND'})
    );
    $("#total").text(
      "Tổng đơn hàng: " +
        total.reduce(function (a, b) {
          return a + b;
        })
    );
  }

  function formatDate(date) {
    let d = String(date.getDate()).padStart(2, "0");
    let m = String(date.getMonth() + 1).padStart(2, "0"); //Tháng 1 là 0!
    let y = date.getFullYear();
    return y + "-" + m + "-" + d;
  }

  function createSelectDate() {
    //Hôm nay
    let today = new Date();
    selectDate.append(
      $("<option>", {
        value: formatDate(today) + "," + formatDate(today),
        text: "Hôm nay",
      })
    );

    //Hôm qua
    let yesterday = new Date();
    yesterday.setDate(today.getDate() - 1);
    selectDate.append(
      $("<option>", {
        value: formatDate(yesterday) + "," + formatDate(yesterday),
        text: "Hôm qua",
      })
    );

    //Tuần này
    let first = today.getDate() - today.getDay() + 1;
    let last = first + 6;
    let firstDay = new Date(new Date().setDate(first));
    let lastDay = new Date(new Date().setDate(last));
    selectDate.append(
      $("<option>", {
        value: formatDate(firstDay) + "," + formatDate(lastDay),
        text: "Tuần này",
      })
    );

    //Tháng này
    let y = today.getFullYear();
    let m = today.getMonth();
    firstDay = new Date(y, m, 1);
    lastDay = new Date(y, m + 1, 0);
    selectDate.append(
      $("<option>", {
        value: formatDate(firstDay) + "," + formatDate(lastDay),
        text: "Tháng này",
      })
    );
  }

  function ajax(dates) {
    $.ajax({
      type: "POST",
      url: "./ajax/index.php",
      data: {
        dateArr: createDateArr(dates),
      },
      dataType: "JSON",
      success: function (response) {
        if (response === "") {
          console.log(response);
          $("#price").text("Tổng tiền: 0VND");
          $("#total").text("Tổng đơn hàng: 0");
          return;
        }

        if (response.length > 1) {
          updateChart(response);
        } else {
          $("#price").text("Tổng tiền: " + response[0]["price"].toLocaleString('it-IT', {style : 'currency', currency : 'VND'}));
          $("#total").text("Tổng đơn hàng: " + response[0]["total"]);
        }
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        console.log("error: ", error);
      },
    });
  }

  renderChart();
  createSelectDate();
  ajax(selectDate.val().split(","));

  selectDate.change(function (e) {
    const dates = this.value.split(",");
    console.log(createDateArr(dates));
    ajax(dates);
    e.preventDefault();
  });

  $(".form_date").datetimepicker({
    format: "dd/mm/yyyy",
    weekStart: 1,
    todayBtn: 1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
    forceParse: 0,
  });

  $("#btnApply").on("click", function () {
    const dates = [];
    dates.push($("#dtpFrom").val());
    dates.push($("#dtpTo").val());
    console.log(dates);
    ajax(dates);
  });
});
