// otherworlds_admin_header
function create_cookie(name, value, days) {
    var expiration = new Date();
    expiration.setTime(
        expiration.getTime() + days * 24 * 60 * 60 * 1000
    );
    var expires = "expires=" + expiration.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

function get_cookie(name) {
    var cookie_name = name + "=";
    var cookies = document.cookie.split(";");
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].trim();
        if (cookie.indexOf(cookie_name) == 0) {
            return cookie.substring(cookie_name.length, cookie.length);
        }
    }
    return ""; //returns "" if no cookie is found
}

function set_cookie(name, new_value) {
    document.cookie = name + "=" + new_value + ";path=/";
}
