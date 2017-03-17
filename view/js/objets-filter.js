/**
 * Created by jmarsal on 3/17/17.
 */

function changeFilterObjet(filter){
    var xhr = getXMLHttpRequest();

    xhr.onreadystatechange = function() {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var imgObj = NewObjectImg(filter),
                container = document.getElementById("booth"),
                ifExist = document.getElementById("imgObj")
                ;

            toggleActiveObjClass(filter);
            var cacheTakePhoto = document.getElementById('form-cache-photo'),
                takePhoto = document.getElementById('startbutton')
                ;
            cacheTakePhoto.style.display = 'block';
            cacheTakePhoto.style.cursor = 'pointer';
            takePhoto.style.display = 'block';
            if (ifExist) {
                ifExist.parentNode.removeChild(ifExist);
            }
            if (imgObj) {
                container.insertBefore(imgObj, container.childNodes[0]);
            }
        }
    };
    var tmp = "objFilter=" + filter;
    xhr.open("post", "objFilterAjax", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}

function NewObjectImg(filter){


    if (filter === 'noneObj'){
        return null;
    } else {
        var imgObj = document.createElement('img');

        if (filter === 'beardMustaches'){
            imgObj.style.width = '16%';
            imgObj.style.marginLeft = "220px";
            imgObj.style.marginTop = "84px";
        } else if (filter === "chapeauPirate"){
            imgObj.style.width = '20%';
            imgObj.style.marginLeft = "220px";
            imgObj.style.marginTop = "-25px";
        } else if (filter === "dog"){
            imgObj.style.width = '20%';
            imgObj.style.marginLeft = "-40px";
            imgObj.style.marginTop = "179px";
        } else if (filter === "epee"){
            imgObj.style.width = '18%';
            imgObj.style.marginLeft = "61px";
            imgObj.style.marginTop = "201px";
        } else if (filter === "epeeLaser"){
            imgObj.style.width = '26%';
            imgObj.style.marginLeft = "61px";
            imgObj.style.marginTop = "201px";
        } else if (filter === 'largeMustache'){
            imgObj.style.width = '10%';
            imgObj.style.marginLeft = "220px";
            imgObj.style.marginTop = "182px";
        } else if (filter === 'lunette'){
            imgObj.style.width = '10%';
            imgObj.style.marginLeft = "220px";
            imgObj.style.marginTop = "89px";
        } else if (filter === 'monkey'){
            imgObj.style.width = '10%';
            imgObj.style.marginLeft = "141px";
            imgObj.style.marginTop = "137px";
        } else if (filter === 'policeHat'){
            imgObj.style.width = '15%';
            imgObj.style.marginLeft = "243px";
            imgObj.style.marginTop = "-4px";
        } else if (filter === 'prismaticMustache'){
            imgObj.style.width = '11%';
            imgObj.style.marginLeft = "243px";
            imgObj.style.marginTop = "181px";
        }
        imgObj.src = '../webroot/images/objets/' + filter + '.png';
        imgObj.style.position = 'absolute';
        imgObj.style.zIndex = '50';
        imgObj.id = 'imgObj';
    }

    return imgObj;
}

function toggleActiveObjClass(filter){
    var buttonIds = [
        'noneObj',
        'beardMustaches',
        'chapeauPirate',
        'dog',
        'epee',
        'epeeLaser',
        'largeMustache',
        'lunette',
        'monkey',
        'policeHat',
        'prismaticMustache'
    ];

    if (!filter){
        filter = 'noneObj';
    }
    for (i = 0; i < buttonIds.length; i++){
        var element = document.getElementById(buttonIds[i]);

        if (element.classList.contains("active")){
            element.classList.remove("active");
        }
    }

    document.getElementById(filter).classList.add("active");
}