/**
 * Created by jbmar on 27/03/2017.
 */

function submitAccueil() {
    var xhr = getXMLHttpRequest(),
        login = document.getElementById('log-accueil').value,
        password = document.getElementById('paswrd_accueil_but').value
    ;

    xhr.onreadystatechange = function () {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText),
                prevMessError = document.getElementById('form_error')

            if (data.messError && !prevMessError){
                var messError = document.createElement('p'),
                    container = document.getElementById('accueil_form')
                ;

                messError.className = "form_error";
                messError.id = "form_error";
                messError.innerHTML = data.messError;
                container.insertBefore(messError, container.lastChild);
            } else if (data.messError && prevMessError){
                prevMessError.innerHTML = data.messError;
            }
        }
    };
    var tmp = "login=" + login + "&passwd=" + password;
    xhr.open("post", "Accueil/submitAccueilAjax", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}
