function blur_element(e) {
    var tok = document.getElementById("token-field");
    tok.style.filter = "blur(5px)";
}
function clear_element(e) {
    var tok = document.getElementById("token-field");
    tok.style.filter = "none";
}

function insert_token(token) {
    var tok = document.getElementById("token-field");
    tok.style.filter = "blur(5px)";
    tok.addEventListener("mouseenter", clear_element);
    tok.addEventListener("mouseleave", blur_element);
    tok.value = token;
}

function clear_token() {
    var tok = document.getElementById("token-field");
    tok.removeEventListener("mouseenter", clear_element);
    tok.removeEventListener("mouseleave", blur_element);
    tok.style.filter = "none";
    tok.value = "";
}

function generate_token() {
    var xhr = new XMLHttpRequest();
    xhr.open( "GET", "../action/generate_token.php", true);
    xhr.onload = (e) => {
        if (xhr.readyState === 4) {
            if (xhr.status === 200 || xhr.status === 201) {
                text = xhr.responseText;
                insert_token(text);
            } else {
                console.error(xhr.statusText);
            }
        }
    }
    xhr.send( null );
}
