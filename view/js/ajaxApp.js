/**
 * Created by jmarsal on 3/7/17.
 */

function getSrcImg(data) {
    finish = document.getElementById('form-cache-photo'),
        finish.addEventListener('click', function(ev) {
            ajaxPhoto(data);
        }, false);
}

function doNothink() {
    document.getElementById('menuFilter');
}

function ajaxPhoto(data64) {
    var xhr = getXMLHttpRequest();

    xhr.onreadystatechange = function() {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText),
                //container = le container de toutes les prev
                container = document.getElementById('prev-img'),
                //img = new prev
                img = document.createElement('img'),
                //del = img de trash
                del = document.createElement('img'),
                //see = img see
                see = document.createElement('img'),
                //div = container pour chaque photos
                divContainer = document.createElement('div'),
                divInputName = document.createElement('div'),
                inputName = document.createElement('input'),
                divContainerAction = document.createElement('div')
            ;

            //Path et id de la prev dans la nouvelle balise img
            img.src = '../' + data.thumbnail;
            img.id = data.idMin;

            divInputName.className = "div-namePhoto";
            inputName.className = "name-photo";
            inputName.type = "text";
            inputName.name = "namePhoto";
            inputName.id = "name-photo-" + data.idMin;
            inputName.value = "Nom pour votre Photo ?";
            inputName.onclick = function () { delValue(data.idMin); };
            inputName.onblur = function () { addValue(data.idMin); };
            //Path de l'img trash pour supprimer la prev
            del.className = "del-button";
            del.src = "../webroot/images/app/Trash.ico";
            del.id = "del-button";
            del.title = "Supprimer la photo ?";
            del.onclick = function() { delImg(data.idMin); };

            //Path de l'img see pour afficher l'image en grand
            see.src = "../webroot/images/app/Loupe.png";
            see.className = "see-button";
            see.id = "see-button";
            see.title = "Agrandir ?";
            see.onclick = function () {
                enlargePhoto(data.idMin);
            };

            divContainerAction.className = "prev-action";

            divContainer.className = "container-prev";
            divContainer.id = "" + data.idMin + "";

            var countElems = document.querySelectorAll('#prev-img .container-prev img');
            if (countElems.length >= 6){
                container.style.overflowY = "auto";
            } else  {
                container.style.overflowY = "none";
                if (countElems.length == 0){
                    container.style.display = "none";
                }
            }
            divInputName.insertBefore(inputName, divInputName.childNodes[0]);

            divContainerAction.insertBefore(see, divContainerAction.childNodes[0]);
            divContainerAction.insertBefore(divInputName, divContainerAction.childNodes[1]);
            divContainerAction.insertBefore(del, divContainerAction.childNodes[2]);

            container.style.display = "block";
            container.insertBefore(divContainer,  container.childNodes[0]);

            var containerPrev = document.getElementById(data.idMin);
            containerPrev.insertBefore(img, containerPrev.childNodes[0]);
            containerPrev.insertBefore(divContainerAction, containerPrev.childNodes[1]);
        }
    };
    var tmp = "img64=" + data64;
    xhr.open("post", "uploadAjax", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}

function delImg(id){
    var xhr = getXMLHttpRequest();
    var imgs = document.getElementById(id);

    xhr.onreadystatechange = function() {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var closeEnlarge = document.getElementById('container-enlarge'),
                replaceVideo = document.getElementById('myvideo'),
                upload = document.getElementById('imgUpload'),
                cacheTakePhoto = document.getElementById('form-cache-photo')
            ;
            if (closeEnlarge != null){
                closeEnlarge.parentNode.removeChild(closeEnlarge);
                if (!upload){
                    replaceVideo.style.display = "inline-block";
                }
                cacheTakePhoto.style.display = 'block';
                cacheTakePhoto.style.cursor = 'pointer';
            }
            imgs.parentNode.removeChild(imgs);
            var countElems = document.querySelectorAll('#prev-img .container-prev img');

            if (countElems.length <= 6){
                var container = document.getElementById('prev-img');

                container.style.overflowY = "hidden";
                if (countElems.length == 0){
                    container.style.display = "none";
                }
            }
        }
    };
    var tmp = "delImg=" + id;
    xhr.open("post", "delAjax", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}

function enlargePhoto(id){
    var xhr = getXMLHttpRequest();

    xhr.onreadystatechange = function() {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText),
                replaceVideo = document.getElementById('booth'),
                closeEnlarge = document.getElementById('container-enlarge'),
                container = document.createElement('div'),
                img = document.createElement('img'),
                close = document.createElement('img'),
                cacheTakePhoto = document.getElementById('buttonActionApp'),
                upload = document.getElementById('imgUpload'),
                fileUpload = document.getElementById('file-upload'),
                closeObjFilter = document.getElementById('imgObj'),
                containerAllFilters = document.getElementById('container-all-filters'),
                containerFilters = document.getElementById('filterHideButton'),
                containerObjs = document.getElementById('objHideButton')
            ;

            if (closeEnlarge != null){
                closeEnlarge.parentNode.removeChild(closeEnlarge);
            }
            if (closeObjFilter){
                closeObjFilter.style.display = 'none';
            }
            if (upload){
                upload.style.display = 'none';
            }
            if (fileUpload){
                fileUpload.style.marginTop = '-70px';
            }
            closeAllFilters();
            containerAllFilters.style.filter = "grayscale(100%)";
            containerFilters.onclick = function () { doNothink(); };
            containerObjs.onclick = function () { doNothink(); };

            container.className = "container-enlarge";
            container.id = "container-enlarge";
            container.style.display = "inline-block";
            container.style.zIndex = "50";
            container.style.height = "1100px";

            img.src = '../' + data.idBig;
            img.className = "img-enlarge";

            close.src = "../webroot/images/app/close2.png";
            close.className = "close-enlarge";
            close.title = "Fermer photo ?";

            // Bug ici lorsque je close img_enlarge
            close.onclick = function () {
                var close = document.getElementById("container-enlarge"),
                    video = document.getElementById('myvideo'),
                    upload = document.getElementById('imgUpload'),
                    cacheTakePhoto = document.getElementById('buttonActionApp'),
                    closeObjFilter = document.getElementById('imgObj')
                    ;

                close.style.display = "none";
                close.style.border = "1px solid red";
                replaceVideo.removeChild(close);

                containerFilters.onclick = function () { showHideFilter(); };
                containerObjs.onclick = function () { showHideObj(); };
                containerAllFilters.style.filter = "none";


                replaceVideo.style.left = "-265px";

                if (upload.classList.contains("active")){
                    upload.style.display = 'inline-block';
                    video.style.display = 'none';
                } else {
                    video.style.display = "inline-block";
                    upload.style.display = 'none';
                }
                if (fileUpload){
                    fileUpload.style.marginTop = '0px';
                }

                cacheTakePhoto.style.display = 'inline-flex';

                if (closeObjFilter){
                    closeObjFilter.style.display = 'block';
                }
            }

            cacheTakePhoto.style.display = 'none';
            var replace = document.getElementById('myvideo');
            replace.style.display = "none"
            replaceVideo.insertBefore(container, replaceVideo.childNodes[0]);
            var container = document.getElementById('container-enlarge');

            container.insertBefore(img, container.childNodes[0]);
            container.insertBefore(close, container.childNodes[1]);
        }
    };

    var tmp = "enlargeImg=" + id;
    xhr.open("post", "enlargeAjax", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}

function delValue(id){
    var changeVal = document.getElementById('name-photo-' + id);
    if (changeVal.value === 'Nom pour votre Photo ?' || changeVal.value !== ''){
        if (changeVal.value !== 'Nom pour votre Photo ?' && changeVal.value !== ''){
            document.getElementById('tmp-photo-' + id).value = changeVal.value;
        }
        changeVal.value = "";
        changeVal.style.fontStyle = "normal";
        changeVal.style.color = "black";
    }
}

function addValue(id) {
    var changeVal = document.getElementById('name-photo-' + id);
    if (changeVal.value === ''){
        if (document.getElementById('tmp-photo-' + id).value !== ''){
            changeVal.value = document.getElementById('tmp-photo-' + id).value;
            document.getElementById('tmp-photo-' + id).value = '';
        } else {
            changeVal.value = "Nom pour votre Photo ?";
        }
        changeVal.style.fontStyle = "italic";
        changeVal.style.color = "lightgrey";
    } else if (changeVal.value !== "Nom pour votre Photo ?"){
        goGalerie(id, changeVal.value);
    }
}

function goGalerie(id, namePhoto) {
    var xhr = getXMLHttpRequest()
    ;

    xhr.onreadystatechange = function() {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var changeVal = document.getElementById('name-photo-' + id);
            changeVal.style.fontStyle = "italic";
            changeVal.style.color = "lightgrey";
        }
    };

    var tmp = "namePhoto=" + namePhoto + "&id=" + id;
    xhr.open("post", "getNamePhoto", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}

function uploadImg() {
    var pathFile = document.getElementById('my-file').files[0].name,
        getType = document.getElementById('my-file').files[0].type,
        validImage = ["image/gif", "image/jpeg", "image/png"],
        messFileOrError = document.getElementById('file-upload'),
        booth = document.getElementById('booth'),
        xhr = getXMLHttpRequest()
    ;

    messFileOrError.style.display = 'block';
    if (pathFile){
        var n = pathFile.lastIndexOf("\\"),
            path = pathFile.substr(n + 1),
            fileInput = document.getElementById('my-file'),
            reader = new FileReader()
        ;

        // Si l'image n'est pas au bon format
        if (validImage.indexOf(getType) < 0) {
            var err = "Mauvais Format ! Veuillez essayer avec un jpg, png ou gif...",
                tmp = "error=" + err
            ;

            xhr.open("post", "uploadPhotoAjax", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send(tmp);
            messFileOrError.innerHTML = err;

        //    Si c'est bon
        } else {
            // Si l'image a une taille correct
            if (document.getElementById('my-file').files[0].size < 2100000){
                var filter = document.getElementById('myvideo').style.filter,
                    newImg = document.getElementById('imgUpload'),
                    backVideo = document.getElementById('back-to-video'),
                    takePhoto = document.getElementById('startbutton'),
                    uploadPhoto = document.getElementById('startbuttonUpload'),
                    divUploadButton = document.getElementById('uploadButton')
                ;
                document.getElementById('myvideo').style.display = 'none';
                divUploadButton.classList.add("active");

                if (newImg){
                    newImg.style.display = 'inline-block';
                    newImg.style.filter = filter;
                    newImg.classList.add("active");
                    booth.classList.add("active");
                }

                reader.addEventListener('load', function() {
                    var messFileImg = "image chargée : " + path,
                        color = "#F39237";

                    xhr.onreadystatechange = function() {
                        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
                            newImg.setAttribute('src', reader.result);
                            backVideo.style.display = 'inline-block';
                            takePhoto.style.display = "none";
                            uploadPhoto.style.display = 'inline-block';
                            uploadPhoto.onclick = function () { ajaxPhoto(encodeURIComponent(reader.result)); };
                            messFileOrError.style.backgroundColor = color;
                            messFileOrError.innerHTML = messFileImg;
                        }
                    };

                    var tmp = "messFileImg=" + messFileImg + "&file=" + pathFile +
                                "&src=" + encodeURIComponent(reader.result) + "&color=" + color;
                    xhr.open("post", "uploadPhotoAjax", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.send(tmp);
                });
                reader.readAsDataURL(fileInput.files[0]);

            } else {
                var err = "Fichier trop volumineux pour etre upload sur le serveur...",
                    tmp = "error=" + err
                ;

                xhr.open("post", "uploadPhotoAjax", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send(tmp);
                messFileOrError.innerHTML = err;
            }
        }

    }

}

function backCamera() {
    var container = document.getElementById('booth'),
        filter = document.getElementById('myvideo'),
        newImg = document.getElementById('imgUpload'),
        backVideo = document.getElementById('back-to-video'),
        takePhoto = document.getElementById('startbutton'),
        uploadPhoto = document.getElementById('startbuttonUpload'),
        divUploadButton = document.getElementById('uploadButton'),
        xhr = getXMLHttpRequest()
    ;

    filter.style.display = 'block';
    filter.style.marginBottom = '15px';
    newImg.style.display = 'none';
    newImg.classList.remove("active");
    newImg.src = "";
    document.getElementById('file-upload').style.display = 'none';
    container.classList.remove("active");
    backVideo.style.display = 'none';
    takePhoto.style.display = 'inline-block';
    uploadPhoto.style.display = 'none';
    divUploadButton.classList.remove("active");


    var tmp = "back=ok";
    xhr.open("post", "backCameraAjax", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}

function sendBase64ForTakePhoto(dataBase64) {
    if (dataBase64){
        dataBase64 = decodeURIComponent(dataBase64);
        dataBase64 = encodeURIComponent(dataBase64);
        ajaxPhoto(dataBase64);
    }
}