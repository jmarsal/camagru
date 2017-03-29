/**
 * Created by jbmar on 27/03/2017.
 */

function submitRegister() {
    var xhr = getXMLHttpRequest(),
        login = document.getElementById('loginRegister').value,
        email = document.getElementById('emailRegister').value,
        password = document.getElementById('passwdRegister').value,
        repPassword = document.getElementById('repPasswdRegister').value
    ;

    xhr.onreadystatechange = function () {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText),
                prevMessError = document.getElementById('form_error')
            ;

            if (data.messError && !prevMessError && data.messError !== "true"){
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
    var tmp = "click=click" + "&login=" + login + "&email=" + email + "&passwd=" + password + "&repPasswd=" + repPassword;
    xhr.open("post", "", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}
