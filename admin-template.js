const body = document.querySelector("body"),
      sidebar = body.querySelector("nav");
      sidebarToggle = body.querySelector(".sidebar-toggle");


let getStatus = localStorage.getItem("status");
if(getStatus && getStatus ==="close"){
    sidebar.classList.toggle("close");
    document.querySelector(':root').style.setProperty('--sidebarSize', '250px');
} else {
    document.querySelector(':root').style.setProperty('--sidebarSize', '73px');
}

sidebarToggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");
    if(sidebar.classList.contains("close")){
        localStorage.setItem("status", "close");
        document.querySelector(':root').style.setProperty('--sidebarSize', '250px');
    }else{
        localStorage.setItem("status", "open");
        document.querySelector(':root').style.setProperty('--sidebarSize', '73px');
    }
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