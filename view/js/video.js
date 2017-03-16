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
        ajaxPhoto(data);
    }

    startbutton.addEventListener('click', function(ev) {
        var player = document.querySelector('#audioPlayer');
        player.play();
        takepicture();
        ev.preventDefault();
    }, false);

})();
