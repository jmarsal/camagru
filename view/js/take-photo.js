/**
 * Created by jmarsal on 3/9/17.
 */

function clickPhoto(data){
    var xhr = getXMLHttpRequest();
    // var src = document.getElementById('photo').getAttribute('src');
    // var src = document.getElementById('photo');
    // var photoSrc = photo.getAttribute('src');

    setTimeout(function () {
        // WAIT 2 SECONDES
        // DO CODE ...
    }, 2000);

    // REQUEST COMPLETE
    xhr.onreadystatechange = function()
    {
        if((state = xhr.readyState) == 4 && xhr.status == 200) {
            console.log("Ma requete a ete excutee avec success");
            // console.log(src);
        }else {
            console.log("state = " + state + " xhr.status" + xhr.status);
        }

    };

    xhr.open("post", "", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    console.log("valueClick=" + data);
    xhr.send("valueClick=" + data);
}
