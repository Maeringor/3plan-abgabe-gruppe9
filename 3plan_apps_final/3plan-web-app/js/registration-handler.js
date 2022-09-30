var firstContent = document.getElementById("input-block1");
var secondContent = document.getElementById("input-block2");


function next() {
    firstContent.style.display="none";
    secondContent.style.display="block";
}

function previous() {
    firstContent.style.display="block";
    secondContent.style.display="none";
}