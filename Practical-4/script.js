function validateLogin() {

    const username = document.getElementById("username");
    const password = document.getElementById("password");

    const usernameValue = username.value.trim();
    const passwordValue = password.value.trim();

    // Reset previous styling
    username.style.border = "";
    password.style.border = "";

    // Student ID empty
    if (usernameValue === "") {
        username.style.border = "2px solid red";
        alert("Please enter Student ID.");
        username.focus();
        return false;
    }

    // Student ID format
    const studentIdPattern = /^[A-Za-z0-9]{5,15}$/;
    if (!studentIdPattern.test(usernameValue)) {
        username.style.border = "2px solid red";
        alert("Invalid Student ID. Use 5 to 15 letters or numbers.");
        username.focus();
        return false;
    }

    // Password empty
    if (passwordValue === "") {
        password.style.border = "2px solid red";
        alert("Please enter Password.");
        password.focus();
        return false;
    }

    // Password length
    if (passwordValue.length < 6) {
        password.style.border = "2px solid red";
        alert("Password must contain at least 6 characters.");
        password.focus();
        return false;
    }

    // Login successful
    alert("Login Successful!");
    window.location.href = "dashboard.html";
    return false;
}

const usernameInput = document.getElementById("username");
const passwordInput = document.getElementById("password");

if (usernameInput) {
    usernameInput.addEventListener("input", function () {
        this.style.border = "";
    });
}

if (passwordInput) {
    passwordInput.addEventListener("input", function () {
        this.style.border = "";
    });
}

const searchBox = document.querySelector('input[placeholder="Search"]');
if (searchBox) {
    searchBox.addEventListener("input", function () {
        const searchText = this.value.toLowerCase();
        const menuItems = document.querySelectorAll("ul li");
        menuItems.forEach(function (item) {
            const text = item.textContent.toLowerCase();
            if (text.includes(searchText)) {
                item.style.display = "";
            } else {
                item.style.display = "none";
            }
        });
    });
}

const menuItems = document.querySelectorAll("ul li");

menuItems.forEach(function (item) {
    item.addEventListener("mouseover", function () {
        this.style.fontWeight = "bold";
    });

    item.addEventListener("mouseout", function () {
        this.style.fontWeight = "";
    });
});

const announcements = document.querySelectorAll("fieldset");
announcements.forEach(function (box) {
    box.addEventListener("click", function () {
        this.style.transform = "scale(1.01)";
        this.style.transition = "0.2s";
    });
});

function createThemeButton() {
    // Don't create duplicate button
    if (document.getElementById("themeButton")) {
        return;
    }

    const button = document.createElement("button");
    button.id = "themeButton";
    button.textContent = "🌙 Dark Mode";
    button.style.margin = "10px";
    button.style.padding = "8px";
    button.style.cursor = "pointer";

    document.body.insertBefore(
        button,
        document.body.firstChild
    );

    // Dark / Light mode button click
    button.addEventListener("click", function () {
        document.body.classList.toggle("dark-mode");
        if (document.body.classList.contains("dark-mode")) {
            button.textContent = "☀️ Light Mode";
            localStorage.setItem("theme", "dark");
        } else {
            button.textContent = "🌙 Dark Mode";
            localStorage.setItem("theme", "light");
        }
    });

    // Restore saved theme
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme === "dark") {
        document.body.classList.add("dark-mode");
        button.textContent = "☀️ Light Mode";
    }
}

const style = document.createElement("style");

style.textContent = `

/* Main Dark Mode */
body.dark-mode {
    background-color: #1e1e1e;
    color: #ffffff;
    transition: 0.3s;
}

/* Main Heading */
body.dark-mode h2,
body.dark-mode h3 {
    color: #ffffff !important;
}

/* Labels */
body.dark-mode label {
    color: #ffffff !important;
}

/* Login Table */
body.dark-mode table {
    background-color: #292929;
    color: #ffffff;
    border-color: #666666;
}

/* Table Cells */

body.dark-mode td {
    background-color: #292929;
    color: #ffffff;
    border-color: #666666;
}

/* Input Boxes */
body.dark-mode input[type="text"],
body.dark-mode input[type="password"],
body.dark-mode input[type="search"] {
    background-color: #3a3a3a;
    color: #ffffff;
    border: 1px solid #888888;
}

/* Input Placeholder */
body.dark-mode input::placeholder {
    color: #cccccc;
}

/* Login Button */
body.dark-mode input[type="submit"] {
    background-color: #4169e1;
    color: #ffffff;
    border: none;
    cursor: pointer;
}

/* Login Button Hover */
body.dark-mode input[type="submit"]:hover {
    background-color: #3157c7;
}

/* Normal Buttons */
body.dark-mode button {
    background-color: #4169e1;
    color: #ffffff;
    border: none;
    cursor: pointer;

}

/* Links */
body.dark-mode a {
    color: #66b3ff;
}

/* Fieldset */
body.dark-mode fieldset {
    background-color: #292929;
    color: #ffffff;
    border-color: #777777;
}

/* Legend */
body.dark-mode legend {
    color: #ffffff;
}

/* Theme Button */
#themeButton {
    position: absolute;
    top: 30px;
    left: 20px;
    padding: 9px 14px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    background-color: #4169e1;
    color: white;
    font-size: 15px;

}

/* Theme Button in Dark Mode */
body.dark-mode #themeButton {
    background-color: #4169e1;
    color: #ffffff;

}

/* Search Box */
body.dark-mode input[placeholder="Search"] {
    background-color: #3a3a3a;
    color: #ffffff;
    border: 1px solid #777777;

}
`;

document.head.appendChild(style);
document.addEventListener("DOMContentLoaded", function () {
    createThemeButton();
}); 