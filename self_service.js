function show_hide_baby_no_question(){
    var multiple_pregnancy = document.getElementById('multiple_pregnancy').value;
    if (multiple_pregnancy=="Yes") {
        document.getElementById('baby_no_question').style.display = "";
    } else{
        document.getElementById('baby_no_question').style.display = "none";
    }
}

function show_hide_miscarriage_no_question(){
    var miscarriage = document.getElementById('miscarriage').value;
    if (miscarriage=="Yes") {
        document.getElementById('miscarriage_no_question').style.display = "";
    } else{
        document.getElementById('miscarriage_no_question').style.display = "none";
    }
}

function measurement_guide(guide_slides){
    var slideIndex = 1;
    showDivs(slideIndex);

    function plusDivs(n) {
        showDivs(sildeIndex += n);
    }

    function showDivs(n) {
        var i;
        var x = document.getElementsByClassName(guide_slides)
        if (n > x.length) { slideIndex = 1 }
        if (n < 1) { slideIndex = x.length };
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        x[slideIndex - 1].style.display = "block";
    }
}