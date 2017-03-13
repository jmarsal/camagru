/**
 * Created by jmarsal on 2/21/17.
 */

(function() {

    var streaming = false;
    video = document.getElementById('myvideo');
    cover = document.getElementById('cover');
    canvas = document.getElementById('canvas');
    photo = document.getElementById('photo');
    startbutton = document.getElementById('startbutton'),
        width = 700;
    height = 220;

    navigator.getMedia = (navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia);

    navigator.getMedia({
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

    video.addEventListener('canplay', function(ev) {
        if (!streaming) {
            height = video.videoHeight / (video.videoWidth / width);
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
        var ctx = canvas.getContext('2d');
        ctx.translate(width, 0);
        ctx.scale(-1, 1);
        ctx.drawImage(video, 0, 0, width, height);
        var data = encodeURIComponent(canvas.toDataURL('image/png'));
        // photo.setAttribute('src', data);
        ajaxPhoto(data);
    }

    startbutton.addEventListener('click', function(ev) {
        takepicture();
        ev.preventDefault();
    }, false);

})();

function getSrcImg(data) {
    finish = document.getElementById('form-cache-photo'),
        finish.addEventListener('click', function(ev) {
            var photo = document.getElementById('photo');
            var photoSrc = photo.getAttribute('src');

            ajaxPhoto(data);
            // var getSrc = document.getElementById("getSrc");

            // getSrc.setAttribute('value', photoSrc);

            // setTimeout(document.getElementById('form-cache-photo').submit(), 40);
        }, false);
}

function ajaxPhoto(data) {
    var xhr = getXMLHttpRequest();
    xhr.onreadystatechange = function() {
        if ((state = xhr.readyState) == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText);

            // creer un nouvel element img (creer nouvel elem html en js)
            // set data.thumbnail em src de img
            // Chopper container prev-img by id
            // put on first new elem img inside container.
        }
    };
    var tmp = "img64=" + data;
    xhr.open("post", "uploadAjax", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(tmp);
}