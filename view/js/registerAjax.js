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
                prevMessError = document.getElementById('form_error'),
                container = document.getElementById('formRegister')
            ;

            if (data.messError && !prevMessError && data.messError !== "true"){
                var messError = document.createElement('p')
                ;

                messError.className = "form_error";
                messError.id = "form_error";
                messError.innerHTML = data.messError;
                container.insertBefore(messError, container.lastChild);
            } else if (data.messError && prevMessError){
                prevMessError.innerHTML = data.messError;
            } else {
                var xhrMail = getXMLHttpRequest();

                //Send Mail
                xhrMail.onreadystatechange = function () {
                    if ((state = xhrMail.readyState) == 4 && xhrMail.status == 200) {
                        console.log(data.info.popup);
                        container.innerHTML = data.info.popup;
                        container.style.paddingBottom = "25%";

                        //Popup et back accueil
                        compte = 5;
                        document.getElementById("compt").innerHTML = compte + " secondes";
                        timer = setInterval('decompte()', 1000);
                    }
                };
                var sendPost = "infoLogin=" + data.info.login +
                    "&infoMail=" + data.info.email +
                    "&infoCle=" + data.info.cle +
                    '&sendMail=ok';
                xhrMail.open("post", "", true);
                xhrMail.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhrMail.send(sendPost);
            }
        }
    };
    var tmp = "click=click" + "&login=" + login + "&email=" + email + "&passwd=" + password + "&repPasswd=" + repPassword;
    xhr.open("post", "", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}

    function decompte(){
        compte--;
        if(compte <= 1) {
            pluriel = "";
        } else {
            pluriel = "s";
        }
        document.getElementById("compt").innerHTML = compte + " seconde" + pluriel;
        if(compte == 0 || compte < 0) {
            compte = 0;
            clearInterval(timer);
            document.location.href="../";
        }
    }
