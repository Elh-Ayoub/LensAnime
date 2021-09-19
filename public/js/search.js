
$("#searchByLogin").on("keyup", function(e) {
    filter = $("#searchByLogin").val().toUpperCase();
    $("#searchByemail").val("")
    row = $(".table-row");
    login = $(".username");
    for (i = 0; i < row.length; i++) {
        bylogin = login[i].textContent || username[i].innerText;
        if (bylogin.toUpperCase().indexOf(filter) > -1) {
            row[i].setAttribute('style', 'display: table-row;');
        } else {
            row[i].setAttribute('style', 'display: none;');
        }
    }
})

$("#searchByemail").on("keyup", function(e) {
    filter = $("#searchByemail").val().toUpperCase();
    $("#searchByLogin").val("");
    row = $(".table-row");
    email = $(".email");
    for (i = 0; i < row.length; i++) {
        byEmail = email[i].textContent || email[i].innerText;
        if (byEmail.toUpperCase().indexOf(filter) > -1) {
            row[i].setAttribute('style', 'display: table-row;');
        } else {
            row[i].setAttribute('style', 'display: none;');
        }
    }
})
$("#searchByCategory").on("keyup", function(e) {
    filter = $(this).val().toUpperCase();
    div = $(".categories");
    title = $(".title");
    for (i = 0; i < div.length; i++) {
        byTitle = title[i].textContent || title[i].innerText;
        if (byTitle.toUpperCase().indexOf(filter) > -1) {
            div[i].setAttribute('style', 'display: table-row;');
        } else {
            div[i].setAttribute('style', 'display: none;');
        }
    }
    console.log(e)
})
