var idle,counter1;

var pageIdCookie = 1;

// total browser inactivity time is 30 minutes
// on the last minute the timeout modal will pop up, with choices yes or no

function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        //date.setTime(date.getTime() + (days*24*60*60*1000));
        date.setTime(date.getTime() + (25*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function eraseCookie(name) {
    document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

// reset session events

$(document ).ready(function() {
    $( window ).on( "load", setSession() );
});

$(document).mousemove(function(){
    resetSession();
});
$(window).scroll(function() {
    resetSession();
});

$(document).keypress(function(){
    resetSession();
});

$(document).click(function(e) {
    resetSession();
});



function setSession() {
    clearInterval(idle);
    idle = setInterval("initSession()", 1740000 ); // 29m browser  inactivity  timer in  miliseconds
    // the interval 'time' is set as soon as the page loads
    myTimer(); // call display session time

}

function  myTimer() {
    // this function is for testing only, add <span> with id = timer1 to see the session time
    // total minutes for session inactivity is 30 minutes
    var minutes = 29;
    var seconds = 59;
    counter1 = setInterval(function() {
        --seconds;

        if (seconds == 0){
            --minutes;
            seconds = 59;

        }
        $("#timer1").html(minutes + ':' + seconds);
        if (minutes == 0){ // if inactivity reach 30 minutes

            clearInterval(counter1);
            return;
        }
    }, 1000);// runs every 1 second
}

function closeModal(){ // if user clicks no, session reset
    setCookie('allModal', 'btnYes',10);
    location.reload();
    //resetSession();
}

function resetSession() {
    //resets the timer. The timer is reset on each of the below events:
    // 1. mousemove   2. mouseclick   3. key press 4. scroll
    //first step: clear the existing timer

    if (idle != 0) {
        clearInterval(idle);
        clearInterval(counter1);
        // second step: implement the timer again
        idle = setInterval("initSession()", 1740000); // reset to 29 minutes (live)
        myTimer(); // show display for testing
        // completed the reset of the timer
    }
}


function sessionLogout() {
    setCookie('allModal', 'btnNo',10);
    window.location = "https://my.forexmart.com/signout";
}

function initSession() { // auto logout timer ( additional 1 minute)
    //show 1 minutes timer modal
    var s = 60;



    var counter = setInterval(function() {
        --s; // 60 seconds countdown
        pageIdCookie = 0;
        $("#session_expire_modal").modal();
        $(".timeoutT").html('(' + s + ')');

        console.log('sec--'+s);



        if (s == 0){
            clearInterval(counter);
            sessionLogout();
            return;
        }

    }, 1000);// runs every 1 second
}

$(window).load(function () {

    var interval_id;
    $(window).focus(function() {
        //console.log(pageIdCookie+'::===::');
        if(getCookie('allModal')=='btnYes' && pageIdCookie == 0){
            closeModal();
        }
        if(getCookie('allModal')=='btnNo' && pageIdCookie == 0){
            sessionLogout();
        }
    });
});



