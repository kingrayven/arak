document.getElementById("age-form").addEventListener("submit", function(event) {
    event.preventDefault();

    let day = document.getElementById("day").value;
    let month = document.getElementById("month").value;
    let year = document.getElementById("year").value;

    if (!day || !month || !year) {
        alert("Please enter your full date of birth.");
        return;
    }

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "verify_age.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (xhr.responseText === "success") {
                document.getElementById("age-verification").style.display = "none";
                alert("Access granted!");
            } else {
                alert("You must be 21 or older to access this site.");
            }
        }
    };
    xhr.send(`day=${day}&month=${month}&year=${year}`);
});

document.getElementById("exit").addEventListener("click", function() {
    window.location.href = "https://www.google.com";
});
