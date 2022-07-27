$(document).ready(function () {
  const commentTable = $("#commentTable").DataTable({
    order: [[0, "desc"]],
    language: {
      url: "//cdn.datatables.net/plug-ins/1.11.3/i18n/vi.json",
    },
  });

  commentTable.on("click", ".btnDelete", function (e) {
    const data = {
      action: "delete",
      id: this.id,
    };
    const rowSelected = $(this).closest("tr");
    $.ajax({
      type: "POST",
      url: "./ajax/comment.php",
      data: data,
      dataType: "JSON",
      success: function (response) {
        console.log(response);
        commentTable.row(rowSelected).remove().draw();
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        console.log("error: ", error);
      },
    });
    e.preventDefault();
  });

  commentTable.on("click", ".btnProduct", function (e) {
    window.open("../details.php?proId=" + this.id, "_blank");
    e.preventDefault();
  });
});
