/**
 *  HOW TO USE AJAX WITH Route ?
 *  First you need to know how to get an object of the class (XMLHTTPRequest)
 *  Second check if the request sent successfully
 *  if the request sent successfully u will got a response
 *  open the request like below
 *  notice :: that I use an existence route "index"
 *  set a function setRequestHeader (in case u use a post request)
 *  use the send function and if u want to send data
 *  put that variables names in the function like below
 *
 */

if (document.getElementById('btn')) {
    document.getElementById('btn').addEventListener('click', function (ev) {

        // ev.preventDefault();
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if (xhr.readyState == xhr.DONE && xhr.status == 200) {
                document.getElementById('name').innerHTML = 'mohammed';
            }
        };

        xhr.open("POST", "index", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("name=ahmed");

    });
}