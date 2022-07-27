function setSidebarHeight() {
  setTimeout(function () {
    var height = $(document).height();
    $(".grid_12").each(function () {
      height -= $(this).outerHeight();
    });
    height -= $("#site_info").outerHeight();
    height -= 1;
    //salert(height);
    $(".sidemenu").css("height", height);
  }, 100);
}

function initializeGallery() {
  // When hovering over gallery li element
  $("ul.gallery li").hover(function () {
    var $image = this;

    // Shows actions when hovering
    $(this).find(".actions").show();

    // If the "x" icon is pressed, show confirmation (#dialog-confirm)
    $(this)
      .find(".actions .delete")
      .click(function () {
        // Confirmation
        $("#dialog-confirm").dialog({
          resizable: false,
          modal: true,
          minHeight: 0,
          draggable: false,
          buttons: {
            Delete: function () {
              $(this).dialog("close");

              // Removes image if delete is pressed
              $($image).fadeOut("slow", function () {
                $($image).remove();
              });
            },

            // Removes dialog if cancel is pressed
            Cancel: function () {
              $(this).dialog("close");
            },
          },
        });

        return false;
      });

    // Changes opacity of the image
    $(this).find("img").css("opacity", "0.5");

    // On hover off
    $(this).hover(
      function () {},
      function () {
        // Hides actions when hovering off
        $(this).find(".actions").hide();

        // Changes opacity of the image back to normal
        $(this).find("img").css("opacity", "1");
      }
    );
  });
}

function setupTinyMCE() {
  $("textarea.tinymce").tinymce({
    // Location of TinyMCE script
    script_url: "js/tiny-mce/tiny_mce.js",

    // General options
    theme: "advanced",
    plugins:
      "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

    // Theme options
    theme_advanced_buttons1:
      "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
    theme_advanced_buttons2:
      "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
    theme_advanced_buttons3:
      "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
    theme_advanced_buttons4:
      "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
    theme_advanced_toolbar_location: "top",
    theme_advanced_toolbar_align: "left",
    theme_advanced_statusbar_location: "bottom",
    theme_advanced_resizing: true,

    // Example content CSS (should be your site CSS)
    content_css: "css/content.css",

    // Drop lists for link/image/media/template dialogs
    template_external_list_url: "lists/template_list.js",
    external_link_list_url: "lists/link_list.js",
    external_image_list_url: "lists/image_list.js",
    media_external_list_url: "lists/media_list.js",

    // Replace values for the template plugin
    template_replace_values: {
      username: "Some User",
      staffid: "991234",
    },
  });
}

//setup DatePicker
function setDatePicker(containerElement) {
  var datePicker = $("#" + containerElement);
  datePicker.datepicker({
    showOn: "button",
    buttonImage: "img/calendar.gif",
    buttonImageOnly: true,
  });
}

function setupLeftMenu() {
  $("#section-menu")
    .accordion({
      header: "a.menuitem",
    })
    .bind("accordionchangestart", function (e, data) {
      data.newHeader.next().andSelf().addClass("current");
      data.oldHeader.next().andSelf().removeClass("current");
    })
    .find("a.menuitem:first")
    .addClass("current")
    .next()
    .addClass("current");

  $("#section-menu .submenu").css("height", "auto");
}
