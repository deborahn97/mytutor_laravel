// Check Passwords
function check_pw() {
    var pw = document.getElementById("password").value;
    var cpw = document.getElementById("confirm_password").value;

    if(pw != cpw) {
        alert("Please make sure the passwords match");
        document.getElementById("reg").disabled = true;
    } else {
        document.getElementById("reg").disabled = false;
    }
}

// Slideshow
var index = 0;
slide();

function slide() {
    var i;
    var x = document.getElementsByClassName("slideshow");

    for(i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }

    index++;

    if(index > x.length) {
        index = 1;
    }

    x[index - 1].style.display = "block";

    setTimeout(slide, 2500);
}
