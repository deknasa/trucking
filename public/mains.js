$(document).ready(function () {
    /* Remove autocomplete */
    $("input").attr("autocomplete", "off");
    $("input, textarea").attr("spellcheck", "false")

    /* Init disable plugin */
    $(".disabled").each(function () {
        $(this).disable();
    });
});

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

/* Disable plugin */
$.fn.disable = function () {
    this.bind("cut copy paste change", function () {
        return false;
    });

    this.on("keydown", (e) => {
        if (!e.altKey && !e.ctrlKey) {
            e.preventDefault();
            return false;
        }
    });

    if (this.is("select")) {
        let selected = this.find("option:selected");

        this.change(() => {
            this.val(selected.val());
        });
    }
};

function setErrorMessages(errors) {
    $(`[name=${Object.keys(errors)[0]}]`).focus();

    $.each(errors, (index, error) => {
        $(`[name=${index}]`).addClass("is-invalid").after(`
          <div class="invalid-feedback">
            ${error}
          </div>
        `);
    });
}

function removeTags(str) {
    if ((str === null) || (str === ''))
        return false;
    else
        str = str.toString();
    return str.replace(/(<([^>]+)>)/ig, '');
}

(function setInputFocus() {
    $("form [name]:not(:hidden, [readonly], [disabled], .disabled)")
        .first()
        .focus();
})();
