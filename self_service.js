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