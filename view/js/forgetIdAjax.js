/**
 * Created by jbmar on 28/03/2017.
 */

function submitForgetId() {
    var xhr = getXMLHttpRequest(),
        email = document.getElementById('emailForgetId').value
    ;

    xhr.onreadystatechange = function () {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText),
                prevMessError = document.getElementById('errorForgetId')

            if (data.messError && !prevMessError){
                var messError = document.createElement('p'),
                    container = document.getElementById('formForgetId')
                ;

                messError.className = "errorForgetId";
                messError.id = "errorForgetId";
                messError.innerHTML = data.messError;
                container.insertBefore(messError, container.lastChild);
            } else if (data.messError && prevMessError){
                prevMessError.innerHTML = data.messError;
            }
        }
    };
    var tmp = "email=" + email + '&click=click';
    xhr.open("post", "", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}
