/**
 * Created by jmarsal on 4/19/17.
 */

function setDateCreated(dateDiv, spanDate, formatDate, id){
    dateDiv.className = "date-comments";
    dateDiv.id = "date-comments" + id;
    spanDate.innerHTML = "le " + formatDate;
}

function reformatDate(date){
    var formatDate = convertDate(date);
    var formatHours = convertHours(date);
    return formatDate + ' à ' + formatHours;
}

function convertDate(inputFormat) {
    function pad(s) { return (s < 10) ? '0' + s : s; }
    var d = new Date(inputFormat);
    return [pad(d.getDate()), pad(d.getMonth()+1), d.getFullYear()].join('/');
}

function convertHours(inputFormat) {
    function pad(s) { return (s < 10) ? '0' + s : s; }
    var d = new Date(inputFormat);
    return [pad(d.getHours()), pad(d.getMinutes())].join(':');
}