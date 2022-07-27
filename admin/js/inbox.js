$(document).ready(function () {
  const orderTable = $("#orderTable").DataTable({
    order: [[0, "desc"]],
    language: {
      url: "//cdn.datatables.net/plug-ins/1.11.3/i18n/vi.json",
    },
  });
  const detailTable = $("#detailTable").DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/1.11.3/i18n/vi.json",
    },
  });

  const dialogDetail = $("#dialogDetail");
  const dialogCustomer = $("#dialogCustomer");
  const dialogCancel = $("#dialogCancel");

  let btnCancel;
  let orderId;

  const btnClose = {
    text: "Đóng",
    click: function () {
      $(this).dialog("close");
    },
  };

  function drawTable(table, data) {
    table.clear();
    table.rows.add(data);
    table.draw();
  }

  dialogCustomer.dialog({
    title: "Thông tin khách hàng",
    autoOpen: false,
    closeOnEscape: true,
    closeText: "Đóng",
    resizable: true,
    minWidth: 700,
    buttons: [btnClose],
  });

  dialogDetail.dialog({
    title: "",
    autoOpen: false,
    closeOnEscape: true,
    closeText: "Đóng",
    resizable: true,
    modal: true,
    width: "80%",
    minWidth: 600,
    buttons: [btnClose],
  });

  function ajax(data, callback) {
    $.ajax({
      type: "POST",
      url: "./ajax/inbox.php",
      data: data,
      dataType: "JSON",
      success: function (response) {
        callback(response);
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        console.log("error: ", error);
      },
    });
  }

  orderTable.on("click", ".btnDetail", function (e) {
    const orderId = $(this).closest("tr").find("td:eq(0)").text();
    dialogDetail.dialog("option", "title", "Chi tiết đơn hàng: " + orderId);

    let data = {
      action: "get",
      orderId: orderId,
    };

    ajax(data, function (responese) {
      drawTable(detailTable, responese);
    });

    dialogDetail.dialog("open");
    e.preventDefault();
  });

  orderTable.on("click", ".btnCustomer", function (e) {
    customerId = this.id;
    const data = {
      action: "getCustomer",
      customerId: customerId,
    };

    ajax(data, function (response) {
      $("#cName").text(response["name"]);
      $("#cPhone").text(response["phone"]);
      $("#cAddress").text(response["address"]);
      $("#cEmail").text(response["email"]);
    });

    dialogCustomer.dialog("open");
    e.preventDefault();
  });

  orderTable.on("click", ".btnChecked", function (e) {
    const closestTr = $(this).closest("tr");
    const orderId = closestTr.find("td:eq(0)").text();
    const statusCell = closestTr.find("td:eq(4)");
    const actionCell = $(this).closest("td");

    const data = {
      action: "checked",
      orderId: orderId,
    };
    ajax(data, function (response) {
      if (response) {
        orderTable.cell(statusCell).data("Đang giao hàng");
        orderTable
          .cell(actionCell)
          .data(
            "<button class='btnShifted btn btn-success'>Giao thành công</button> " +
              "<button class='btnCancel btn btn-danger'>Hủy giao hàng</button>"
          );
      }
    });
  });

  orderTable.on("click", ".btnShifted", function (e) {
    const closestTr = $(this).closest("tr");
    const statusCell = closestTr.find("td:eq(4)");
    const orderId = closestTr.find("td:eq(0)").text();

    const btnCancel = $(this).closest("td").children(".btnCancel");
    const btnShifted = $(this);

    const data = {
      action: "shifted",
      orderId: orderId,
    };

    ajax(data, function (response) {
      if (response) {
        orderTable.cell(statusCell).data("Giao thành công");
        btnCancel.remove();
        btnShifted.remove();
      }
    });
  });

  dialogCancel.dialog({
    title: "Hủy đơn hàng",
    autoOpen: false,
    closeOnEscape: true,
    closeText: "Đóng",
    resizable: false,
    modal: true,
    buttons: [
      {
        text: "Đồng ý",
        click: function () {
          const statusCell = btnCancel.closest("tr").find("td:eq(4)");
          const btnChecked = btnCancel.closest("td").children(".btnChecked");
          const btnShifted = btnCancel.closest("td").children(".btnShifted");
          const data = {
            action: "cancel",
            orderId: orderId,
          };

          ajax(data, function (response) {
            if (response) {
              orderTable.cell(statusCell).data("Đã hủy đơn");
              btnCancel.remove();
              if (btnChecked) btnChecked.remove();
              if (btnShifted) btnShifted.remove();
            }
          });
          $(this).dialog("close");
        },
      },
      btnClose,
    ],
  });

  orderTable.on("click", ".btnCancel", function (e) {
    btnCancel = $(this);
    orderId = btnCancel.closest("tr").find("td:eq(0)").text();
    dialogCancel.children("span").html("Số: " + orderId);
    dialogCancel.dialog("open");
  });
});
