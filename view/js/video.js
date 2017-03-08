/**
 * Created by jmarsal on 2/21/17.
 */

(function () {

    var streaming = false;
    video = document.getElementById('myvideo');
    console.log(video);
    cover = document.getElementById('cover');
    canvas = document.getElementById('canvas');
    photo = document.getElementById('photo');
    startbutton  = document.getElementById('startbutton'),
        width = 700;
    height = 220;

    navigator.getMedia = (  navigator.getUserMedia ||
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia ||
    navigator.msGetUserMedia);

    navigator.getMedia(
        {
            video: true,
            audio: false
        },
        function(stream) {
            if (navigator.mozGetUserMedia) {
                video.mozSrcObject = stream;
            } else {
                var vendorURL = window.URL || window.webkitURL;
                video.src = vendorURL.createObjectURL(stream);
            }
            video.play();
        },
        function(err) {
            console.log("An error occured! " + err);
        }
    );

    video.addEventListener('canplay', function(ev){
        if (!streaming) {
            height = video.videoHeight / (video.videoWidth/width);
            video.setAttribute('width', width);
            video.setAttribute('height', height);
            canvas.setAttribute('width', width);
            canvas.setAttribute('height', height);
            streaming = true;
        }
    }, false);

    function takepicture() {
        canvas.width = width;
        canvas.height = height;
        var ctx =canvas.getContext('2d');
        ctx.translate(width,  0);
        ctx.scale(-1, 1);
        ctx.drawImage(video, 0, 0, width, height);
        var data = canvas.toDataURL('image/png');
        photo.setAttribute('src', data);
    }

    startbutton.addEventListener('click', function(ev){
        takepicture();
        ev.preventDefault();
    }, false);

})();

function getSrcImg() {
    finish = document.getElementById('form-cache-photo'),
        finish.addEventListener('click', function (ev) {
            var photo = document.getElementById('photo');
            var photoSrc = photo.getAttribute('src');
            var getSrc = document.getElementById("getSrc");

            getSrc.setAttribute('value', photoSrc);
            setTimeout(document.getElementById('form-cache-photo').submit(), 40);
        }, false);
}

function changeFilter(filter){
    document.getElementById("myvideo").style.filter = filter;
    // var xhr = new XMLHttpRequest();
    //         var tmp = "$_POST['filter']=" + filter;
    //         xhr.open("POST", "getFilter", true);
    //
    //         xhr.send(tmp);
    //         console.log(tmp);
    var xhr;
    try {  xhr = new ActiveXObject('Msxml2.XMLHTTP'); alert('connection ok 1');  }
    catch (e)
    {
        try {   xhr = new ActiveXObject('Microsoft.XMLHTTP'); alert('connection ok 2'); }
        catch (e2)
        {
            try {  xhr = new XMLHttpRequest(); alert('connection ok 3'); }
            catch (e3) {  xhr = false;  alert('connection KO'); }
        }
    }

    xhr.onreadystatechange  = function()
    {
        if(xhr.readyState  == 4)
        {
            alert('readyState = 4');
            if(xhr.status  == 200){
                alert('xhrstatus = 200');
                // document.getElementById('filter').style.display = "none";
                // document.ajax.dyn="Received:"  + xhr.responseText;
            }
            else{
                alert("Error code " + xhr.status);
                document.ajax.dyn="Error code " + xhr.status;
            }
        }
    };
    var tmp = "$_POST['filter']=" + filter;
    xhr.open("POST", "getFilter", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}
