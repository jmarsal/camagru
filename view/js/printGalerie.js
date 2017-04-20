/**
 * Created by jmarsal on 4/19/17.
 */

/*
    Click sur image de commentaires.
    Construit le container avec tous les messages, ainsi que le cote d'affichage et sa couleur.
 */

function commmentsClick(id) {
    var xhr = getXMLHttpRequest()
    ;

    xhr.onreadystatechange = function () {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText),
                containerDiv = document.getElementById("container-comments" + id),
                newcommentsDiv = document.getElementById("new-comments-container" + id),
                comments = data.comments,
                logins = data.logins,
                idCreateComments = 0,
                loginPrec = ""
            ;

            // debugger;
            if (newcommentsDiv.style.display != "block"){
                newcommentsDiv.style.display = "block";

                //Check si il existe des message precedent, et si ils sont du meme user que celui qui est log
                if (!logins){
                    logins = new Array;
                    logins[0] = data.logSession;
                }

                for (i = 0; i < comments.length - 1; i++){
                    if (i == 0){
                        getModulo(data.logSession, data.logSession, logins[i]);
                    }
                    else {
                        loginPrec = logins[i - 1];
                        getModulo(data.logSession, loginPrec, logins[i]);
                    }
                    // console.log(comments.userComment);
                    constructCommentsInDocument(containerDiv, comments, logins, idCreateComments, i);
                    containerDiv.scrollTop = containerDiv.scrollHeight + 100;
                    idCreateComments++;
                }
            } else {
                newcommentsDiv.style.display = "none";
                removeContainerComments(id);
            }
        }
    };
    var tmp = "commentsGalerie=" + id;
    xhr.open("post", "getCommentsAjaxGalerie", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}

function checkIfMessAndUser(userLogin, firstUserComment) {
    if (userLogin && firstUserComment){
        var check = userLogin.search(firstUserComment);

        check = (check == 0) ? 0 : -1;
        return check;
    } else {
        return 0;
    }
}

function getModulo(userLogin, login1, login2) {
    /*
     Si le login precedent est le meme que l'actuel et que le meme que l'user
     ex:    jibe jibe jibe
            cote gauche

     Si le login precedent est le meme que l'actuel et que != de l'user
     ex:    jibe jibe elodie
            cote droit

     Si le login precedent est != de l'actuel et que le meme que l'user
     ex:    jibe elodie jibe
            cote gauche

     Si le login precedent est != de l'actuel et que != de l'user
     ex:    jibe elodie elodie
            cote droit

     Inversement de position si user a commente, un autre login et encore un autre login et a nouveau l'user
     ex:    jibe elodie antoine jibe
            jibe
                elodie
            antoine
                jibe
            cote gauche
     */
    if ((checkIfMessAndUser(login1, login2)) == 0 && userLogin === login1){
        modulo = 0;
        color1 = "250, 118, 33";
        color2 = "243, 146, 55";
        whichColor = 0;
    } else {
        modulo = 1;
        color1 = "115, 115, 104";
        color2 = "47, 79, 79";
        whichColor = 1;
    }
}

function constructCommentsInDocument(containerComments, comments, logins, id, i){ // containerDiv = conatiner-comments; sameUser = meme utilisateur que le premier comment ? 0 pour oui, -1 non
    console.log(containerComments, comments, logins, id, i);
    var spanComment = document.createElement('div'),
        spanDate = document.createElement('span'),
        spanLogin = document.createElement('span'),
        containerInteract = document.createElement("div"),
        interactsDiv = document.createElement("div"),
        dateDiv = document.createElement("div"),
        loginDiv = document.createElement("div"),
        commentsDiv = document.createElement("div"),
        hrDiv = document.createElement("div"),
        hr = document.createElement('hr'),
        date = new Date(comments[i].created),
        formatDate = reformatDate(date)
    ;

    // setColorsGetModulo(logins, id, i, null, 1);
    setHr(hrDiv, hr, modulo);
    setContainerAllComments(containerInteract, id);
    setTopPartComment(interactsDiv, id,  color1, modulo);
    setDateCreated(dateDiv, spanDate, formatDate, id);
    setLoginDiv(loginDiv, spanLogin, logins, id, i);
    setBottomPartComment(commentsDiv, spanComment, comments, i, id);

    containerComments.style.display = "block";
    setElementsInDocument(loginDiv, spanLogin, dateDiv, spanDate, interactsDiv, commentsDiv,
        spanComment, hrDiv, hr,  containerInteract, containerComments, i);
}

// function constructCommentsInDocument(containerComments, comments, logins, id, i){ // containerDiv = conatiner-comments
//     var spanComment = document.createElement('span'),
//         spanDate = document.createElement('span'),
//         spanLogin = document.createElement('span'),
//         containerInteract = document.createElement("div"),
//         interactsDiv = document.createElement("div"),
//         dateDiv = document.createElement("div"),
//         loginDiv = document.createElement("div"),
//         commentsDiv = document.createElement("div"),
//         hrDiv = document.createElement("div"),
//         hr = document.createElement('hr'),
//         date = new Date(comments[i].created),
//         formatDate = reformatDate(date)
//     ;
//
//     // setColorsGetModulo(logins, i, preSpanLog, moduloDivSpan, id)
//     // setColorsGetModulo(data.info, containerDiv.length, preSpanLog, moduloDivSpan, id);
//     setColorsGetModulo(logins, id, i, null, 1);
//     setHr(hrDiv, hr, modulo);
//     setContainerAllComments(containerInteract, id);
//     setTopPartComment(interactsDiv, id,  color1, modulo);
//     setDateCreated(dateDiv, spanDate, formatDate, id);
//     setLoginDiv(loginDiv, spanLogin, logins, id, i);
//     setBottomPartComment(commentsDiv, spanComment, comments, i, id,  color1, color2, modulo);
//     containerComments.style.display = "block";
//     setElementsInDocument(loginDiv, spanLogin, dateDiv, spanDate, interactsDiv, commentsDiv,
//         spanComment, hrDiv, hr,  containerInteract, containerComments, i);
// }
