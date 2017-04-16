/**
 * Created by jbmar on 28/03/2017.
 */

function submitForgetId() {
    var xhr = getXMLHttpRequest(),
        email = document.getElementById('emailForgetId').value
    ;

    xhr.onreadystatechange = function () {
        if ((state = xhr.readyState) == 4 && xhr.status == 200 ) {
            var data = JSON.parse(xhr.responseText),
                prevMessError = document.getElementById('errorForgetId'),
                container = document.getElementById('formForgetId');
            ;

            // var tmp = (xhr.responseText);
            // console.log(tmp);
            if (data.messError && !prevMessError){
                var messError = document.createElement('p')
                ;

                messError.className = "errorForgetId";
                messError.id = "errorForgetId";
                messError.innerHTML = data.messError;
                container.insertBefore(messError, container.childNodes[3]);
            } else if (data.messError && prevMessError){
                prevMessError.innerHTML = data.messError;
            } else {
                var xhrMail = getXMLHttpRequest();

                //Send Mail
                xhrMail.onreadystatechange = function () {
                    if ((state = xhrMail.readyState) == 4 && xhrMail.status == 200) {
                        container.innerHTML = data.popup.popup;
                        container.style.paddingBottom = "25%";

                        //Popup et back accueil
                        compte = 5;
                        document.getElementById("compt").innerHTML = compte + " secondes";
                        timer = setInterval('decompte()', 1000);
                    }
                };
                var sendPost = "infoLogin=" + data.popup.login +
                                "&infoMail=" + data.popup.email +
                                "&infoCle=" + data.popup.cle +
                                '&sendMail=ok';
                xhrMail.open("post", "", true);
                xhrMail.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhrMail.send(sendPost);
            }
        }
    };
    var tmp = "email=" + email + '&click=click';
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
