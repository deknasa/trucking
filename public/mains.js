$(window).on("resize", function (event) {
    if ($(window).width() > 990) {
        $("body").addClass("sidebar-close sidebar-collapse");
    }
});

$(".sidebars").click(function (e) {
    $("body").addClass("sidebar-open");
    e.preventDefault();
});

$(document).mouseup(function (e) {
    var container = $(".main-sidebar");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        if ($("body").hasClass("sidebar-open")) {
            $("body").removeClass("sidebar-open");
        }
    }
});

function setErrorMessages(errors) {
    $(`[name=${Object.keys(errors)[0]}]`).focus()
    
    $.each(errors, (index, error) => {
        $(`[name=${index}]`).addClass("is-invalid").after(`
          <div class="invalid-feedback">
            ${error}
          </div>
        `);
    });
}

(function setInputFocus() {
    $('form [name]:not(:hidden, [readonly], [disabled], .disabled)').first().focus()
})()