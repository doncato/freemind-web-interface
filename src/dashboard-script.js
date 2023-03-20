// START ADD NEW
function addNew() {
    var correct = true;
    
    var type = document.getElementById('type');
    var title = document.getElementById('title');
    var description = document.getElementById('description');

    // Verify type
    var priority = 100;
    var rigid = 100;

    switch (type.value) {
        case 'Event':
            priority = 10;
            rigid = 10;
            type.classList.remove("is-invalid");
            break;
        case 'ToDo':
            priority = 5;
            rigid = 100;
            type.classList.remove("is-invalid");
            break;
        case 'Appointment':
            priority = 10;
            rigid = 1;
            type.classList.remove("is-invalid")
            break;
        default:
            type.classList.add("is-invalid")
            correct = false;
    }
    
    // Verify Title and Description
    if (!title.value) {
        title.classList.add("is-invalid")
        correct = false;
    } else {
        title.classList.remove("is-invalid")
    }
    if (!description.value) {
        description.classList.add("is-invalid")
        correct = false;
    } else {
        description.classList.remove("is-invalid")
    }

    // Verify Date
    var dueDate = new Date(
        `20${document.getElementById('dueDate-5').value}`,        // Year
        document.getElementById('dueDate-4').value - 1,           // Month
        document.getElementById('dueDate-3').value,               // Day
        parseInt(document.getElementById('dueDate-1').value),     // Hours 
        document.getElementById('dueDate-2').value,               // Minute
        0,
    )
    var due = Math.floor(dueDate / 1000);

    if (correct) {
        var next = {
            "type": type.value,
            "name": title.value,
            "description": description.value,
            "due": due,
            "priority": priority,
            "rigid": rigid,
        }
        httpGet("./action/fetch.php", insertNew, next);

        addNewClear();
    }
}

function addNewClear() {
    var eles = document.getElementsByClassName("addNewEle");
    Array.from(eles).forEach(function(ele) {
        ele.value = "";
        ele.classList.remove("is-invalid")
    })
    document.getElementById("type").value="Event"; // Hardcoded badass but who cares;
    
    var modalEl = document.getElementById("addNewPrompt");
    var modal = bootstrap.Modal.getInstance(modalEl);
    modal.hide();
}

function adjustVal(obj) {
    if (obj.value.length >= 2 && (parseInt(obj.value) > obj.max || parseInt(obj.value) < obj.min)) {
        obj.value = "";
    } else if (obj.value.length >= 2) {
        var nxt = obj.nextElementSibling
        if(nxt) {
            nxt = nxt.nextElementSibling;
        }
        if (nxt) {
            nxt.focus();
        }
    }
}

function insertYearMin() {
    var ele = document.getElementById("dueDate-5");
    var today = new Date();
    const year = today.getFullYear();
    ele.min = year - 2000; // Maybe change this if we hit the year 2100 smh
}

function insertNew(xml, next) {
    if (xml.startsWith("<?xml version=\"1.0\" encoding=\"UTF-8\"?>")) {
        var old_ids = [];

        var parser = new DOMParser();
        var doc = parser.parseFromString(xml, "text/xml");
        var regis = doc.getElementsByTagName("registry")[0]

        for (const e of regis.getElementsByTagName("entry")) {
            old_ids.push(e.getAttribute("id"))
        }

        var nextEle = doc.createElement("entry");

        var n = 0
        while (n === 0 || n in old_ids) {
            n = Math.floor(Math.random() * 65535);
        }
        nextEle.setAttribute("id", n)

        for (const [key, value] of Object.entries(next)) {
            var add = doc.createElement(key);
            add.innerHTML = value;
            nextEle.appendChild(add);
        }
        regis.appendChild(nextEle)

        httpPost("./action/update.php", doc, true);
    }
}

// END ADD NEW
// START DELETE ENTRY
function deleteEntry(obj) {
    httpGet("./action/fetch.php", removeEntry, obj.id);
}

function removeEntry(xml, id) {
    if (xml.startsWith("<?xml version=\"1.0\" encoding=\"UTF-8\"?>")) {
        var parser = new DOMParser();
        var doc = parser.parseFromString(xml, "text/xml");
        var regis = doc.getElementsByTagName("registry")[0]

        for (const e of regis.getElementsByTagName("entry")) {
            if (id === e.getAttribute("id")) {
                regis.removeChild(e)
            }
        }

        httpPost("./action/update.php", doc, true);
    }
}
// END DELETE ENTRY

function httpGet(reqURL, handler, passon) {
    var xhr = new XMLHttpRequest();
    xhr.open( "GET", reqURL, true);
    xhr.onload = (e) => {
        if (xhr.readyState === 4) {
            if (xhr.status === 200 || xhr.status === 201) {
                xml = xhr.responseText;
                handler(xml, passon);
            } else {
                console.error(xhr.statusText);
            }
        }
    }
    xhr.send( null );
}

function httpPost(reqURL, payload, update) {
    var xhr = new XMLHttpRequest();
    xhr.open( "POST", reqURL, true);
    xhr.onload = (e) => {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                console.log("Another Success");
                if (update) {
                    httpGet("./action/fetch.php", mapOutcome);
                }
            } else {
                console.error(xhr.statusText);
            }
        }
    }
    xhr.send( payload );
}

// START FILL TABLE

function fillTable(element, xdoc) {
    var content = ""
    var doc = xdoc[0].getElementsByTagName("entry");
    for (var i = 0; i < doc.length; i++) {
        var e = doc[i];

        var dueDate = new Date();
        var due = e.getElementsByTagName("due")[0].innerHTML
        dueDate.setTime(due*1000);
        dateString = dueDate.toLocaleString('de-DE');

        content += `<tr id="${e.getAttribute('id')}">
            <td>${e.getElementsByTagName("name")[0].innerHTML}</td>
            <td>${e.getElementsByTagName("description")[0].innerHTML}</td>
            <td>${dateString}</td>
            <td><button type="button" class="btn-close" onclick="deleteEntry(this.parentElement.parentElement)"></button></td>
        </tr>`;
    }
    element.innerHTML = content;
}

function mapOutcome(xml, waisted) { // Because I'm stupid & tired
    if (xml.startsWith("<?xml version=\"1.0\" encoding=\"UTF-8\"?>")) {
        var parser = new DOMParser();
        var doc = parser.parseFromString(xml, "text/xml");
        fillTable(document.getElementById("table"), doc.getElementsByTagName("registry"));
    }
}
// END FILL TABLE


// Launch on Load
httpGet("./action/fetch.php", mapOutcome);
// Update the year of the addNew form
insertYearMin();