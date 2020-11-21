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

function show_hide_tobacco_no_question(){
    var miscarriage = document.getElementById('tobacco_use').value;
    if (miscarriage=="Yes") {
        document.getElementById('tobacco_no_question').style.display = "";
    } else{
        document.getElementById('tobacco_no_question').style.display = "none";
    }
}

function show_hide_alcohol_no_question(){
    var miscarriage = document.getElementById('alcohol_use').value;
    if (miscarriage=="Yes") {
        document.getElementById('alcohol_no_question').style.display = "";
    } else{
        document.getElementById('alcohol_no_question').style.display = "none";
    }
}