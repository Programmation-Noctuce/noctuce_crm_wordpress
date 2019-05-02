var crm_right_menu;
    
window.addEventListener("load", function () {
    crm_right_menu = document.getElementsByClassName("crm_right_menu")[0];

    var clientList = document.getElementsByClassName("client-list")[0];

    for(var i = 0; i < clientList.children.length - 1; i++) {
        var li = clientList.children[i];

        li.addEventListener("click", function (e) {
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function(e) {
                if (this.readyState == 4 && this.status == 200) {
                    var crm_right_menu;
                    crm_right_menu = document.getElementsByClassName("crm_right_menu")[0];
                    crm_right_menu.innerHTML = 
                        this.responseText;
                    prepareUpdate();
                }
            };

            var id = e.target.id.split('-')[2];
            var url = window.origin + ajaxurl;

            xhttp.open("GET", url +
                        "?action=ajax_noctuce_crm_get_client&client_id=" + id, true);
            xhttp.send();
        });
    }

    {
        var li = document.getElementById("new-client");

        li.addEventListener("click", function (e) {
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function(e) {
                if (this.readyState == 4 && this.status == 200) {
                    var crm_right_menu;
                    crm_right_menu = document.getElementsByClassName("crm_right_menu")[0];
                    crm_right_menu.innerHTML = 
                        this.responseText;
                }
            };

            //var id = e.target.id.split('-')[2];
            var url = window.origin + ajaxurl;

            xhttp.open("GET", url +
                        "?action=ajax_noctuce_crm_get_client&client_id=-1", true);
            xhttp.send();
        });
    }
});

var prepareUpdate = function () {
    crm_right_menu.nameInput = crm_right_menu.children[2];
    //crm_right_menu.nameButton = crm_right_menu.children[3];
    crm_right_menu.children[3].addEventListener("click", unlockInput);

    crm_right_menu.roleInput = crm_right_menu.children[5];
    //crm_right_menu.roleButton = crm_right_menu.children[6];
    crm_right_menu.children[6].addEventListener("click", unlockInput);

    crm_right_menu.entrepriseInput = crm_right_menu.children[8];
    //crm_right_menu.entrepriseButton = crm_right_menu.children[9];
    crm_right_menu.children[9].addEventListener("click", unlockInput);

    crm_right_menu.updateButton = crm_right_menu.children[10];
    crm_right_menu.updateButton.addEventListener("click", update);
}

var unlockInput = function (e) {
    e.target.previousElementSibling.disabled = false;
    e.target.parentElement.removeChild(e.target);

    crm_right_menu.updateButton.style.display = "";
}

var update = function(e) {
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function(e) {
        if (this.readyState == 4 && this.status == 200) {
            var crm_right_menu;
            crm_right_menu = document.getElementsByClassName("crm_right_menu")[0];
            crm_right_menu.innerHTML = 
                this.responseText;
        }
    };

    //var id = e.target.id.split('-')[2];
    var url = window.origin + ajaxurl;

    xhttp.open("GET", url +
                "?action=ajax_noctuce_crm_get_client&client_id=-1", true);
    xhttp.send();
}