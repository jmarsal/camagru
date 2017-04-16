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
            ;

            if (data.messError && !prevMessError && data.messError !== 'true'){
                var messError = document.createElement('p'),
                    container = document.getElementById('form-accueil')
                ;

                messError.className = "form_error";
                messError.id = "form_error";
                messError.innerHTML = data.messError;
                container.insertBefore(messError, container.childNodes[0]);
            } else if (data.messError && prevMessError && data.messError !== 'true'){
                prevMessError.innerHTML = data.messError;
            } else if (data.redirect){
                document.location = "App/appCamagru";
            }
        }
    };
    var tmp = "login=" + login + "&passwd=" + password;
    xhr.open("post", "Accueil/submitAccueilAjax", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}
