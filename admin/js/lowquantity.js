$(document).ready(function () {
  const dialogAddProduct = $("#dialogAddProduct");

  let productId = -1;

  const productTable = $("#productTable").DataTable({
    order: [[4, "desc"]],
    columnDefs: [{ width: "7%", targets: 0 }],
    language: {
      url: "//cdn.datatables.net/plug-ins/1.11.3/i18n/vi.json",
    },
  });

  tinymce.init({
    selector: "#description",
    height: "300",
  });
  tinymce.activeEditor.setMode("readonly");

  function drawTable(data) {
    productTable.clear();
    productTable.rows.add(data);
    productTable.draw();
  }

  function ajax(number) {
    const data = {
      action: "lowQuantity",
      number: number,
    };
    $.ajax({
      type: "POST",
      url: "./ajax/product.php",
      data: data,
      dataType: "JSON",
      success: function (response) {
        drawTable(response);
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        console.log("error: ", error);
      },
    });
  }

  const btnClose = {
    text: "Đóng",
    click: function () {
      $(this).dialog("close");
    },
  };

  dialogAddProduct.dialog({
    title: "Chi tiết sản phẩm",
    autoOpen: false,
    closeOnEscape: true,
    closeText: "Đóng",
    resizable: true,
    modal: true,
    minWidth: 700,
    buttons: [btnClose],
  });

  $("#inputNumber").keyup(function () {
    let number = $(this).val();
    if (number === "") number = 0;
    if (number < 0) {
      number = 0;
      $(this).val(0);
    }
    ajax(number);
  });

  $("#inputNumber").focus(function () {
    $(this).select();
  });

  productTable.on("click", ".btnDetail", function (e) {
    productId = $(this).closest("tr").find("td:eq(0)").text();
    let data = {
      action: "get",
      productId: productId,
    };
    $.ajax({
      type: "POST",
      url: "./ajax/product.php",
      data: data,
      dataType: "JSON",
      cache: false,
      success: function (response) {
        $("#name").val(response["name"]);
        $("#category").val(response["catId"]);
        $("#brand").val(response["brandId"]);
        tinymce.get("description").setContent(response["desc"]);
        $("#price").val(response["price"]);
        $("#quantity").val(response["quantity"]);
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        console.log("error: ", error);
      },
    });

    dialogAddProduct.dialog("open");
    e.preventDefault();
  });
});
