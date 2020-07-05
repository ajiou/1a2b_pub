let urlParams = new URLSearchParams(window.location.search);
let state = urlParams.get('action')

if (state === "reg_success") {
    document.write("<div class=\"alert alert-success\" role=\"alert\" id=\"alert\">\n" +
        "    註冊成功\n" +
        "</div>")
} else if (state === "logout") {
    document.write("<div class=\"alert alert-success\" role=\"alert\" id=\"alert\">\n" +
        "    已登出\n" +
        "</div>")
}