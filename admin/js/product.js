$(document).ready(function () {
  const dialogAddProduct = $("#dialogAddProduct");
  const slDialog = $("#sl");

  let dialogClosed;
  let productId = -1;
  let sl = 0;
  let rowSelected;

  const productTable = $("#productTable").DataTable({
    order: [[0, "desc"]],
    columnDefs: [{ width: "7%", targets: 0 }],
    language: {
      url: "//cdn.datatables.net/plug-ins/1.11.3/i18n/vi.json",
    },
  });

  tinymce.init({
    selector: "#description",
    height: "350",
    plugins: "image code",
    toolbar: "undo redo | link image",
    image_title: true,
    images_upload_url: "./ajax/product.php",

    //Đường dẫn ảnh là: localhost + images_upload_base_path + respone.location
    images_upload_base_path: "./",

    images_upload_credentials: true,
  });

  function drawTable(data) {
    productTable.clear();
    productTable.rows.add(data);
    productTable.draw();
  }

  function ajax(data) {
    $.ajax({
      type: "POST",
      url: "./ajax/product.php",
      data: data,
      dataType: "JSON",
      cache: false,
      processData: false,
      contentType: false,
      success: function (response) {
        drawTable(response);
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        console.log("error: ", error);
      },
    });
  }

  function deleteProduct(data) {
    $.ajax({
      type: "POST",
      url: "./ajax/product.php",
      data: data,
      dataType: "JSON",
      cache: false,
      success: function (response) {
        productTable.row(rowSelected).remove().draw();
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        console.log("error: ", error);
      },
    });
  }

  function clearDialog() {
    $("#name").val("");
    $("#category").val(-1);
    $("#brand").val(-1);
    tinymce.get("description").setContent("");
    $("#price").val("");
  }

  const btnSave = {
    text: "Lưu",
    click: function () {
      const name = $("#name").val().trim();
      const category = $("#category").val();
      const brand = $("#brand").val();
      const description = tinymce.get("description").getContent();
      const price = $("#price").val();
      const image = $("#image").prop("files")[0];
      const quantity = $("#quantity").val();

      //   if (input === "") {
      //     txtProductName.addClass("inputErr");
      //     return;
      //   }
      //   const productName = input.replace(/\s+/g, " ");

      let data = new FormData();
      data.append("name", name);
      data.append("category", category);
      data.append("brand", brand);
      data.append("description", description);
      data.append("price", price);
      data.append("image", image);
      data.append("quantity", quantity);

      if (productId === -1) {
        data.append("action", "add");
        ajax(data);
      } else {
        data.append("action", "edit");
        data.append("productId", productId);
        ajax(data);
        $(this).dialog("close");
      }
    },
  };

  const btnClose = {
    text: "Đóng",
    click: function () {
      $(this).dialog("close");
    },
  };

  const btnConfirm = {
    text: "Đồng ý",
    click: function () {
      const data = {
        action: "delete",
        productId: productId,
      };
      deleteProduct(data);
      $(this).dialog("close");
    },
  };

  const btnCancel = {
    text: "Hủy",
    click: function () {
      $(this).dialog("close");
    },
  };

  dialogAddProduct.dialog({
    title: "",
    autoOpen: false,
    closeOnEscape: true,
    closeText: "Đóng",
    resizable: true,
    modal: true,
    minWidth: 700,
    buttons: [btnSave, btnClose],
  });

  function overlayClickClose() {
    console.log(dialogClosed);
    if (dialogClosed) {
      slDialog.dialog("close");
    }
    dialogClosed = true;
  }

  slDialog.dialog({
    autoOpen: false,
    closeOnEscape: true,
    closeText: "Đóng",
    resizable: false,
    minWidth: 1,
    minHeight: 1,
    dialogClass: "no-titlebar",
    open: function () {
      dialogClosed = true;
      $(document).bind("click", overlayClickClose);
    },
    close: function () {
      $(document).unbind("click");
    },
  });

  $("#sl").click(function (e) {
    dialogClosed = false;
    e.preventDefault();
  });

  $("#dialogDeleteProduct").dialog({
    title: "Bạn chắc chắn muốn xóa?",
    autoOpen: false,
    closeOnEscape: true,
    closeText: "Đóng",
    resizable: false,
    modal: true,
    buttons: [btnConfirm, btnCancel],
  });

  $("#btnAddProduct").on("click", function (e) {
    productId = -1;
    clearDialog();

    dialogAddProduct.dialog("option", "title", "Thêm sản phẩm");
    dialogAddProduct.dialog("open");
    e.preventDefault();
  });

  productTable.on("click", ".btnDelete", function (e) {
    rowSelected = $(this).closest("tr");
    productId = rowSelected.find("td:eq(0)").text();

    $("#dialogDeleteProduct > span").html(
      $(this).closest("tr").find("td:eq(1)").text()
    );
    $("#dialogDeleteProduct").dialog("open");
    e.preventDefault();
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

    dialogAddProduct.dialog("option", "title", "Chi tiết sản phẩm");
    dialogAddProduct.dialog("open");
    e.preventDefault();
  });

  productTable.on("click", ".btnSl", function (e) {
    productId = $(this).closest("tr").find("td:eq(0)").text();
    sl = this.id;
    $("#slAdd").val("");
    const target = $(this);
    slDialog
      .dialog({
        position: { my: "center top", at: "center bottom", of: target },
      })
      .dialog("open");
    dialogClosed = false;
    e.preventDefault();
  });

  $("#sl").on("click", "#btnSlAdd", function (e) {
    const inputVal = $("#slAdd").val();
    if (inputVal != "" && inputVal != 0) {
      const data = {
        action: "addSl",
        id: productId,
        sl: +sl + +inputVal,
      };
      $.ajax({
        type: "POST",
        url: "./ajax/product.php",
        data: data,
        dataType: "JSON",
        success: function (response) {
          drawTable(response);
        },
      });
      productId = -1;
      sl = 0;
    }
    slDialog.dialog("close");
  });

  $("#image").change(function (e) {
    const image = $("#image").files;
    console.log(URL.createObjectURL(image));
    if (image) {
      $("#preview").attr("src", URL.createObjectURL(image));
    }
    e.preventDefault();
  });
});
