// Получение содержимого файла для редактирования
function getFileContent(filename) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("edit-content").value = this.responseText;
        }
    };
    xhttp.open("GET", "get_file_content.php?filename=" + filename, true);
    xhttp.send();
}

// Обработчик клика на кнопке "Редактировать"
document.querySelectorAll(".edit-button").forEach(function(button) {
    button.addEventListener("click", function() {
        var filename = this.dataset.filename;
        document.getElementById("page-filename").textContent = filename;
        getFileContent(filename);
    });
});
