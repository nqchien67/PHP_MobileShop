$(document).ready(function () {
  const dialogAddBrand = $("#dialogAddBrand");
  const txtBrandName = dialogAddBrand.children("input");

  let brandId = 0;

  const brandTable = $("#brandTable").DataTable({
    order: [[0, "desc"]],
    language: {
      url: "//cdn.datatables.net/plug-ins/1.11.3/i18n/vi.json",
    },
  });

  function drawTable(data) {
    brandTable.clear();
    brandTable.rows.add(data);
    brandTable.draw();
  }

  function ajax(data) {
    $.ajax({
      type: "POST",
      url: "./ajax/brand.php",
      data: data,
      dataType: "JSON",
      cache: false,
      success: function (response) {
        console.log(response);
        drawTable(response);
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        console.log("error: ", error);
      },
    });
  }

  const btnSave = {
    text: "Lưu",
    click: function () {
      const input = txtBrandName.val().trim();
      if (input === "") {
        txtBrandName.addClass("inputErr");
        return;
      }
      const brandName = input.replace(/\s+/g, " ");

      if (brandId === 0) {
        const data = {
          action: "add",
          brandName: brandName,
        };
        ajax(data);
      } else {
        const data = {
          action: "edit",
          brandId: brandId,
          brandName: brandName,
        };
        ajax(data);
        $(this).dialog("close");
        brandId = 0;
      }
      txtBrandName.val("");
    },
  };

  const btnClose = {
    text: "Đóng",
    click: function () {
      $(this).dialog("close");
      brandId = 0;
    },
  };

  const btnConfirm = {
    text: "Đồng ý",
    click: function () {
      const data = {
        action: "delete",
        brandId: brandId,
      };
      ajax(data);
      $(this).dialog("close");
      brandId = 0;
    },
  };

  const btnCancel = {
    text: "Hủy",
    click: function () {
      $(this).dialog("close");
      brandId = 0;
    },
  };

  dialogAddBrand.dialog({
    title: "",
    autoOpen: false,
    closeOnEscape: true,
    closeText: "Đóng",
    resizable: false,
    modal: true,
    buttons: [btnSave, btnClose],
  });

  $("#dialogDeleteBrand").dialog({
    title: "Bạn chắc chắn muốn xóa?",
    autoOpen: false,
    closeOnEscape: true,
    closeText: "Đóng",
    resizable: false,
    modal: true,
    buttons: [btnConfirm, btnCancel],
  });

  $("#btnAddBrand").on("click", function (e) {
    categoryId = 0;
    txtBrandName.removeClass();
    txtBrandName.val("");

    dialogAddBrand.dialog("option", "title", "Thêm thương hiệu");
    dialogAddBrand.dialog("open");
    e.preventDefault();
  });

  brandTable.on("click", ".btnDelete", function (e) {
    brandId = $(this).closest("tr").find("td:eq(0)").text();
    $("#dialogDeleteBrand > span").html(
      $(this).closest("tr").find("td:eq(1)").text()
    );
    $("#dialogDeleteBrand").dialog("open");
    e.preventDefault();
  });

  brandTable.on("click", ".btnEdit", function (e) {
    txtBrandName.removeClass();

    brandId = $(this).closest("tr").find("td:eq(0)").text();
    txtBrandName.val($(this).closest("tr").find("td:eq(1)").text());

    dialogAddBrand.dialog("option", "title", "Sửa thương hiệu");
    dialogAddBrand.dialog("open");
    e.preventDefault();
  });
});
