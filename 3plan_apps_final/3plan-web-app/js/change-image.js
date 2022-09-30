// opens local file browser
function openImageFileExplorer() {
    document.querySelector('#profilePic').click();
}

// changes locally displayed img to new one
function displayImage(e) {
    var maxFileSize = 5 * 1024 * 1024; // 5mb limit
    if(e.files[0] && e.files[0].size <= maxFileSize) {
        var reader = new FileReader();

        reader.onload = function(e) {
            document.querySelector('#profilePicDisplay').setAttribute('src', e.target.result);
        }

        reader.readAsDataURL(e.files[0]);
    }
    document.getElementById("saveImg").style.display="block";
}