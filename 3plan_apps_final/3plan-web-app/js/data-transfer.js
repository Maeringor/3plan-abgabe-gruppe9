// converts data (a data array) to a json and sends it to a correspoding php dao
function sendData(data, urlDAO) {
    let xhr = new XMLHttpRequest();
    let url = urlDAO;

    xhr.open("POST", url, true);

    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("Data send successfully");
            location.reload();
        }
    }

    xhr.send(data);
}