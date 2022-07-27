$(document).ready(function () {
  const dialogAddCat = $("#dialogAddCat");
  const txtCatName = dialogAddCat.children("input");

  let categoryId = 0;

  const catTable = $("#catTable").DataTable({
    order: [[0, "desc"]],
    language: {
      url: "//cdn.datatables.net/plug-ins/1.11.3/i18n/vi.json",
    },
  });

  function drawTable(data) {
    catTable.clear();
    catTable.rows.add(data);
    catTable.draw();
  }

  function ajax(data) {
    $.ajax({
      type: "POST",
      url: "./ajax/category.php",
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

  const btnSave = {
    text: "Lưu",
    click: function () {
      const input = txtCatName.val().trim();
      if (input === "") {
        txtCatName.addClass("inputErr");
        return;
      }
      const categoryName = input.replace(/\s+/g, " ");

      if (categoryId === 0) {
        const data = {
          action: "add",
          categoryName: categoryName,
        };
        ajax(data);
      } else {
        const data = {
          action: "edit",
          categoryId: categoryId,
          categoryName: categoryName,
        };
        ajax(data);
        $(this).dialog("close");
      }
      txtCatName.val("");
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
        categoryId: categoryId,
      };
      ajax(data);
      $(this).dialog("close");
    },
  };

  const btnCancel = {
    text: "Hủy",
    click: function () {
      $(this).dialog("close");
    },
  };

  $(dialogAddCat).dialog({
    title: "",
    autoOpen: false,
    closeOnEscape: true,
    closeText: "Đóng",
    resizable: false,
    modal: true,
    buttons: [btnSave, btnClose],
  });

  $("#dialogDeleteCat").dialog({
    title: "Bạn chắc chắn muốn xóa?",
    autoOpen: false,
    closeOnEscape: true,
    closeText: "Đóng",
    resizable: false,
    modal: true,
    buttons: [btnConfirm, btnCancel],
  });

  $("#btnAddCat").on("click", function (e) {
    categoryId = 0;
    txtCatName.removeClass();
    txtCatName.val("");

    dialogAddCat.dialog("option", "title", "Thêm danh mục");
    dialogAddCat.dialog("open");
    e.preventDefault();
  });

  catTable.on("click", ".btnDelete", function (e) {
    categoryId = $(this).closest("tr").find("td:eq(0)").text();
    $("#dialogDeleteCat > span").html(
      $(this).closest("tr").find("td:eq(1)").text()
    );
    $("#dialogDeleteCat").dialog("open");
    e.preventDefault();
  });

  catTable.on("click", ".btnEdit", function (e) {
    txtCatName.removeClass();

    categoryId = $(this).closest("tr").find("td:eq(0)").text();
    txtCatName.val($(this).closest("tr").find("td:eq(1)").text());

    dialogAddCat.dialog("option", "title", "Sửa danh mục");
    dialogAddCat.dialog("open");
    e.preventDefault();
  });
});
