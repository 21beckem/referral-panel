const sidebar = document.body.querySelector("nav");

let getStatus = localStorage.getItem("sidebar-status");
if(getStatus && getStatus ==="close") {
    sidebar.classList.toggle("close");
    document.querySelector(':root').style.setProperty('--sidebarSize', '73px');
} else {
    document.querySelector(':root').style.setProperty('--sidebarSize', '250px');
}

window.addEventListener("load", (e) => {
    document.body.querySelector(".sidebar-toggle").addEventListener("click", () => {
        sidebar.classList.toggle("close");
        if(sidebar.classList.contains("close")){
            localStorage.setItem("sidebar-status", "close");
            document.querySelector(':root').style.setProperty('--sidebarSize', '73px');
        }else{
            localStorage.setItem("sidebar-status", "open");
            document.querySelector(':root').style.setProperty('--sidebarSize', '250px');
        }
    });
    document.querySelector(':root').style.setProperty('--tran-05', 'all 0.5s ease');
});

function setDontRefresh(trueOrfalse) {
    if (trueOrfalse) {
        window.onbeforeunload = function() {
            return "Data will be lost if you leave the page, are you sure?";
        };
    } else {
        window.onbeforeunload = undefined;
    }
}
function setLastUrl(u) {
    let url = 'setLastUrl.php?url='+encodeURI(u);
    fetch(url);
    return url;
}
String.prototype.toTitleCase = function() {
    var splitStr = this.toLowerCase().split(' ');
    for (var i = 0; i < splitStr.length; i++) {
        splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
    }
    return splitStr.join(' '); 
}
String.prototype.addSlashes = function() {
    return this.replace(/\\/g, '\\\\').
        replace(/\u0008/g, '\\b').
        replace(/\t/g, '\\t').
        replace(/\n/g, '\\n').
        replace(/\f/g, '\\f').
        replace(/\r/g, '\\r').
        replace(/'/g, '\\\'').
        replace(/"/g, '\\"');
}