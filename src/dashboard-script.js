function httpGet(reqURL) {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "GET", reqURL, false);
    xmlHttp.send( null );
    return xmlHttp.responseText;
}

function fillTable(element, xdoc) {
    var content = ""
    var doc = xdoc[0].getElementsByTagName("entry");
    for (var i = 0; i < doc.length; i++) {
        var e = doc[i];

        var dueDate = new Date();
        var due = e.getElementsByTagName("due")[0].innerHTML
        dueDate.setTime(due*1000);
        dateString = dueDate.toUTCString();

        content += `<tr>
            <td>${e.getElementsByTagName("name")[0].innerHTML}</td>
            <td>${e.getElementsByTagName("description")[0].innerHTML}</td>
            <td>${dateString}</td>
        </tr>`;
    }
    element.innerHTML = content;
}


var xml = httpGet("./api/fetch.php");
if (xml.startsWith("<?xml version=\"1.0\" encoding=\"UTF-8\"?>")) {
    var parser = new DOMParser();
    var doc = parser.parseFromString(xml, "text/xml");
    fillTable(document.getElementById("table"), doc.getElementsByTagName("registry"));
}