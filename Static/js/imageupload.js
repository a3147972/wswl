
function alertWarning(t, i, e, n) {
    if ("string" == typeof t) var s = t,
    i = i,
    e = e,
    n = n;
    else var s = t.text,
    i = t.position,
    e = t.maxWidth || "",
    n = t.bgColor || "";
    if (0 == t.autoClose) var a = !1;
    else var a = !0;
    switch ($(".warningBox").remove(), i) {
    case "top":
        var r = createDiv("warningBox fixTop", s);
        break;
    case "mid":
        var r = createDiv("warningBox fixMid", s);
        break;
    default:
        var r = createDiv("warningBox fixTop", s)
    }
    return e && (r.style.maxWidth = e),
    n && (r.style.backgroundColor = n),
    a && ($(r).addClass("fadeOut"), r.addEventListener("webkitAnimationEnd",
    function() {
        $(this).remove()
    })),
    $(r)
}




function enableBtn(id) {
    if ($("#" + id).hasClass('btn-disable')) {
        $('#' + id).removeClass('btn-disable');
    }
}
function disableBtn(id) {
    if (!$("#" + id).hasClass('btn-disable')) {
        $('#' + id).addClass('btn-disable');
    }
}

function alertWarning(t, i, e, n) {
    if ("string" == typeof t) var s = t,
    i = i,
    e = e,
    n = n;
    else var s = t.text,
    i = t.position,
    e = t.maxWidth || "",
    n = t.bgColor || "";
    if (0 == t.autoClose) var a = !1;
    else var a = !0;
    switch ($(".warningBox").remove(), i) {
    case "top":
        var r = createDiv("warningBox fixTop", s);
        break;
    case "mid":
        var r = createDiv("warningBox fixMid", s);
        break;
    default:
        var r = createDiv("warningBox fixTop", s)
    }

}

function alertLoading(t) {
    var i = t || "\u52a0\u8f7d\u4e2d...",
    e = '<div class="loading-box2 ta-c ptb20 white"><i class="iconfont icon-loading size20 "></i><p class="mt10 size12">' + i + "</p></div>",
    n = createDiv("loadindBox fixMid pct40", e);
    return n
}
function removeLoading() {
    $(".loadindBox").remove()
}
function createDiv(t, i) {
    var e = document.createElement("div");
    return e.className = t,
    i && (e.innerHTML = i),
    document.body.appendChild(e),
    e
}
function fixHeight(t, i, e) {
    var n, s = t[0];
    s.style.height = i + "px",
    s.scrollHeight > i && (n = s.scrollHeight > e ? e: s.scrollHeight - 10, s.style.height = n + 10 + "px")
}
function isFixBottom(t) {
    function i() {
        n.height() < $(window).height() ? (e.hasClass("fixBottom") || e.addClass("fixBottom"), n.height() + s > $(window).height() && e.hasClass("fixBottom") && e.removeClass("fixBottom")) : e.hasClass("fixBottom") && e.removeClass("fixBottom")
    }
    var e = $(".autoFixBottom"),
    n = $(".main-wrap"),
    s = t ? t: 0;
    e[0] && (i(s), $(window).on("resize",
    function() {
        i(s)
    }))
}