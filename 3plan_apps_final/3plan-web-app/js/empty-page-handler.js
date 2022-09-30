function checkDisplay() {
    let numberOfCards = document.querySelectorAll('.card').length;
    let numberOfLargeCards = document.querySelectorAll('.card-large').length;
    numberOfCards += numberOfLargeCards;
    const emptyElement = document.getElementById('empty-tab');
    console.log(numberOfCards);

    if (numberOfCards - 1 != 0) {
        emptyElement.style.display="none";
    } else if (numberOfCards - 1 == 0) {
        emptyElement.style.display="flex";
    }
}
window.onload = checkDisplay();