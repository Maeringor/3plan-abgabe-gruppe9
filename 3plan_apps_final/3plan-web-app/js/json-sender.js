function sendJSON(urlDAO) {
    let xhr = new XMLHttpRequest();
    let url = urlDAO;

    xhr.open("POST", url, true);

    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(this.responseText);
        }
    }

    var value = [];

    const arrTodoItems = document.querySelectorAll('.todo-item');
    for (let index = 0; index < arrTodoItems.length; index++) {
        var boolItemChecked = arrTodoItems[index].querySelector('[name="item-checked"]').checked ? 1 : 0;
        var inputText = arrTodoItems[index].querySelector('[name="item-text"]').value;
        console.log(inputText);
        // add value to key in array for json
        value.push({checked: boolItemChecked, text: inputText});
    }

    var data = JSON.stringify(value);

    xhr.send(data);
}