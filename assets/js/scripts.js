window.addEventListener("load", function () {
    var contactList = document.getElementsByClassName("contact-list")[0];

    for(var i = 0; i < contactList.children.length; i++) {
        var li = contactList.children[i];

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

            var id = e.target.id.split('-')[2];
            var url = window.origin + ajaxurl;

            xhttp.open("GET", url +
                        "?action=ajax_noctuce_crm_get_contact&contact_id=" + id, true);
            //xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            //xhttp.send("action=ajax_noctuce_crm_get_contact&contact_id=" + id);
            xhttp.send();
        });
    }
});