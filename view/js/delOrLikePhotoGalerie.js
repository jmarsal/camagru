/**
 * Created by jmarsal on 4/19/17.
 */
function delImgDb(id) {
    var xhr = getXMLHttpRequest();

    xhr.onreadystatechange = function() {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var remove = document.getElementById(id);

            if (remove) {
                remove.parentNode.removeChild(remove);
            }
        }
    };
    var tmp = "delImgGalerie=" + id;
    xhr.open("post", "delAjaxGalerie", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}

function likeImg(id) {
    var xhr = getXMLHttpRequest(),
        likeImg = document.getElementById("like-galerie" + id),
        replaceLike = likeImg.src.search('nonelike');
    ;

    xhr.onreadystatechange = function() {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText),
                likeSpan = document.getElementById("like-span" + id)
                tmp = null;
            ;

            if (replaceLike === -1) {
                tmp = likeImg.src.replace('like', 'nonelike');
                likeImg.title = "j'aime";
            } else {
                tmp = likeImg.src.replace('nonelike', 'like');
                likeImg.title = "j'aime plus";
            }
            likeImg.src = tmp;
            if (likeSpan){
                likeSpan.firstChild.nodeValue = data.nbLike;
            }
        }
    };
    var tmp = "likeImgGalerie=" + id;
    xhr.open("post", "likeAjaxGalerie", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}