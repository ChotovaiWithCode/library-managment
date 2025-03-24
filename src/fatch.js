function searchBooks() {
    let searchValue = document.getElementById('Titlebooks').value;

    let xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_books.php?search=" + searchValue, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("results").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}