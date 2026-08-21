// LOGIN VALIDATION
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

    // Go to Dashboard
    window.location.href = "dashboard.html";

    return false;
}

// FEEDBACK VALIDATION
function validateFeedback() {
    const studentName = document.getElementById("studentname");
    const studentId = document.getElementById("studentid");
    const department = document.getElementById("department");
    const semester = document.getElementById("semester");
    const faculty = document.getElementById("faculty");
    const subject = document.getElementById("subject");
    const overallRating = document.getElementById("overallRating");
    const suggestions = document.getElementById("suggestions");

    // Reset borders
    studentName.style.border = "";
    studentId.style.border = "";
    department.style.border = "";
    semester.style.border = "";
    faculty.style.border = "";
    subject.style.border = "";
    overallRating.style.border = "";
    suggestions.style.border = "";

    // Student Name
    if (studentName.value.trim() === "") {
        studentName.style.border = "2px solid red";
        alert("Please enter Student Name.");
        studentName.focus();
        return false;
    }

    // Student ID
    if (studentId.value.trim() === "") {
        studentId.style.border = "2px solid red";
        alert("Please enter Student ID.");
        studentId.focus();
        return false;
    }

    // Department
    if (department.value.trim() === "") {
        department.style.border = "2px solid red";
        alert("Please enter Department.");
        department.focus();
        return false;
    }

    // Semester
    if (semester.value.trim() === "") {
        semester.style.border = "2px solid red";
        alert("Please enter Semester.");
        semester.focus();
        return false;
    }

    // Faculty Name
    if (faculty.value.trim() === "") {
        faculty.style.border = "2px solid red";
        alert("Please enter Faculty Name.");
        faculty.focus();
        return false;
    }

    // Subject
    if (subject.value.trim() === "") {
        subject.style.border = "2px solid red";
        alert("Please enter Subject.");
        subject.focus();
        return false;
    }

    // Teaching Quality
    if (!document.querySelector('input[name="teaching"]:checked')) {
        alert("Please rate Teaching Quality.");
        return false;
    }

    // Communication Skills
    if (!document.querySelector('input[name="communication"]:checked')) {
        alert("Please rate Communication Skills.");
        return false;
    }

    // Subject Knowledge
    if (!document.querySelector('input[name="knowledge"]:checked')) {
        alert("Please rate Subject Knowledge.");
        return false;
    }

    // Punctuality
    if (!document.querySelector('input[name="time"]:checked')) {
        alert("Please rate Punctuality.");
        return false;
    }

    // Doubt Solving
    if (!document.querySelector('input[name="doubt"]:checked')) {
        alert("Please rate Doubt Solving Ability.");
        return false;
    }

    // Overall Rating
    if (overallRating.value === "Select Rating") {
        overallRating.style.border = "2px solid red";
        alert("Please select Overall Rating.");
        overallRating.focus();
        return false;
    }

    // Suggestions
    if (suggestions.value.trim() === "") {
        suggestions.style.border = "2px solid red";
        alert("Please enter your Suggestions.");
        suggestions.focus();
        return false;
    }

    // Success
    alert("Feedback Submitted Successfully!");
    return false;
}

// PROFILE VALIDATION
function validateProfile() {
    const studentId = document.getElementById("profileStudentId");
    const name = document.getElementById("profileName");
    const department = document.getElementById("profileDepartment");
    const semester = document.getElementById("profileSemester");
    const email = document.getElementById("profileEmail");
    const mobile = document.getElementById("profileMobile");

    // Reset borders
    studentId.style.border = "";
    name.style.border = "";
    department.style.border = "";
    semester.style.border = "";
    email.style.border = "";
    mobile.style.border = "";

    // Student ID
    if (studentId.value.trim() === "") {
        studentId.style.border = "2px solid red";
        alert("Please enter Student ID.");
        studentId.focus();
        return false;
    }

    // Student ID format
    const studentIdPattern = /^[A-Za-z0-9]{5,15}$/;
    if (!studentIdPattern.test(studentId.value.trim())) {
        studentId.style.border = "2px solid red";
        alert("Invalid Student ID. Use 5 to 15 letters or numbers.");
        studentId.focus();
        return false;
    }

    // Name
    if (name.value.trim() === "") {
        name.style.border = "2px solid red";
        alert("Please enter Full Name.");
        name.focus();
        return false;
    }

    // Department
    if (department.value === "Select Department") {
        department.style.border = "2px solid red";
        alert("Please select Department.");
        department.focus();
        return false;
    }

    // Semester
    if (semester.value === "Select Semester") {
        semester.style.border = "2px solid red";
        alert("Please select Semester.");
        semester.focus();
        return false;
    }

    // Email
    if (email.value.trim() === "") {
        email.style.border = "2px solid red";
        alert("Please enter Email.");
        email.focus();
        return false;
    }

    // Email format
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email.value.trim())) {
        email.style.border = "2px solid red";
        alert("Please enter a valid Email.");
        email.focus();
        return false;
    }

    // Mobile
    if (mobile.value.trim() === "") {
        mobile.style.border = "2px solid red";
        alert("Please enter Mobile Number.");
        mobile.focus();
        return false;
    }

    // Mobile must contain 10 digits
    const mobilePattern = /^[0-9]{10}$/;
    if (!mobilePattern.test(mobile.value.trim())) {
        mobile.style.border = "2px solid red";
        alert("Mobile Number must contain exactly 10 digits.");
        mobile.focus();
        return false;
    }

    // Success
    alert("Profile Saved Successfully!");
    return false;
}

// PAGE LOAD
document.addEventListener("DOMContentLoaded", function () {
    
    // LOGIN INPUT BORDER RESET
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

    // FEEDBACK INPUT BORDER RESET
    const feedbackInputs = document.querySelectorAll(
        "#studentname, #studentid, #department, #semester, #faculty, #subject, #overallRating, #suggestions"
    );

    feedbackInputs.forEach(function (input) {
        input.addEventListener("input", function () {
            this.style.border = "";
        });
        input.addEventListener("change", function () {
            this.style.border = "";
        });
    });

    // PROFILE INPUT BORDER RESET
    const profileInputs = document.querySelectorAll(
        "#profileStudentId, #profileName, #profileDepartment, #profileSemester, #profileEmail, #profileMobile"
    );

    profileInputs.forEach(function (input) {
        input.addEventListener("input", function () {
            this.style.border = "";
        });
        input.addEventListener("change", function () {
            this.style.border = "";
        });
    });

    // SEARCH
    const searchBox =
        document.querySelector('input[placeholder="Search"]');
    if (searchBox) {
        searchBox.addEventListener("input", function () {
            const searchText = this.value.toLowerCase();
            const menuItems = document.querySelectorAll("ul li");
        menuItems.forEach(function (item) {
            const text =
                    item.textContent.toLowerCase();
                if (text.includes(searchText)) {
                    item.style.display = "";
                } else {
                    item.style.display = "none";
                }
            });
        });
    }

    // MENU HOVER
    const menuItems =
        document.querySelectorAll("ul li");

    menuItems.forEach(function (item) {
        item.addEventListener("mouseover", function () {
            this.style.fontWeight = "bold";
        });

        item.addEventListener("mouseout", function () {
            this.style.fontWeight = "";
        });
    });

    // FIELDSET CLICK EFFECT
    const fieldsets =
        document.querySelectorAll("fieldset");

    fieldsets.forEach(function (box) {
        box.addEventListener("click", function () {
            this.style.transform = "scale(1.01)";
            this.style.transition = "0.2s";
        });
    });

    // PROFILE IMAGE PREVIEW
    const profilePicture =  document.getElementById("profilePicture");
    const previewImage =  document.getElementById("previewImage");

    if (profilePicture && previewImage) {
        profilePicture.addEventListener("change", function () {
            const file = profilePicture.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    previewImage.src = event.target.result;
                    previewImage.style.display = "block";
                };
                reader.readAsDataURL(file);
            } else {
                previewImage.style.display = "none";
            }
        });
    }

    // DARK / LIGHT MODE
    let themeButton = document.getElementById("themeButton");

    if (!themeButton) {
        themeButton = document.createElement("button");
        themeButton.id = "themeButton";
        themeButton.type = "button";
        themeButton.textContent = "🌙 Dark Mode";
        themeButton.style.position = "fixed";
        themeButton.style.top = "15px";
        themeButton.style.left = "15px";
        themeButton.style.zIndex = "9999";
        themeButton.style.padding = "10px 15px";
        themeButton.style.cursor = "pointer";
        themeButton.style.border = "none";
        themeButton.style.borderRadius = "8px";
        themeButton.style.fontSize = "14px";
        document.body.appendChild(themeButton);
    }

    // CREATE DARK MODE CSS USING JS
    let darkStyle = document.getElementById("darkModeStyle");
    if (!darkStyle) {
        darkStyle =  document.createElement("style");
        darkStyle.id = "darkModeStyle";
        darkStyle.textContent = `

        body.dark-mode {
            background: linear-gradient(135deg, #0f172a, #1e1b4b) !important;
            color: #e5e7eb !important;
        }

        body.dark-mode header,
        body.dark-mode nav,
        body.dark-mode main,
        body.dark-mode section,
        body.dark-mode article,
        body.dark-mode aside,
        body.dark-mode footer {
            background: transparent !important;
            color: #e5e7eb !important;
        }

        body.dark-mode fieldset {
            background: #1e293b !important;
            color: #f1f5f9 !important;
            border: 1px solid #475569 !important;
            border-radius: 10px !important;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.35) !important;
        }

        body.dark-mode div {
            color: #e5e7eb !important;
        }

        body.dark-mode h1,
        body.dark-mode h2,
        body.dark-mode h3,
        body.dark-mode h4,
        body.dark-mode h5,
        body.dark-mode h6 {
            color: #f8fafc !important;
        }

        body.dark-mode p,
        body.dark-mode label,
        body.dark-mode legend,
        body.dark-mode li,
        body.dark-mode td,
        body.dark-mode th {
            color: #dbeafe !important;
        }

        body.dark-mode input,
        body.dark-mode textarea,
        body.dark-mode select {
            background: #273449 !important;
            color: #f8fafc !important;
            border: 1px solid #64748b !important;
            border-radius: 6px !important;
        }

        body.dark-mode input:focus,
        body.dark-mode textarea:focus,
        body.dark-mode select:focus {
            background: #2d3a52 !important;
            border: 2px solid #818cf8 !important;
            outline: none !important;
            box-shadow: 0 0 8px rgba(129, 140, 248, 0.35) !important;
        }

        body.dark-mode button:not(#themeButton) {
            background: linear-gradient(
                135deg,
                #4f46e5,
                #7c3aed
            ) !important;
            color: white !important;
            border: none !important;
            border-radius: 7px !important;
        }

        body.dark-mode button:not(#themeButton):hover {
            background: linear-gradient(
                135deg,
                #6366f1,
                #8b5cf6
            ) !important;
            transform: translateY(-1px);
        }

        body.dark-mode a {
            color: #93c5fd !important;
        }

        body.dark-mode a:hover {
            color: #c4b5fd !important;
        }

        body.dark-mode table {
            background: #1e293b !important;
            color: #e5e7eb !important;
            border-color: #475569 !important;
        }

        body.dark-mode tr,
        body.dark-mode td,
        body.dark-mode th {
            background: #1e293b !important;
            color: #e5e7eb !important;
            border-color: #475569 !important;
        }

        body.dark-mode #themeButton {
            background: linear-gradient(
                135deg,
                #f59e0b,
                #f97316
            ) !important;

            color: white !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3) !important;
        }

        body.dark-mode #themeButton:hover {
            background: linear-gradient(
                135deg,
                #fbbf24,
                #fb923c
            ) !important;
            transform: translateY(-1px);
        }
        `;

        document.head.appendChild(darkStyle);

    }

    // DARK MODE FUNCTION
    function enableDarkMode() {
        document.body.classList.add("dark-mode");
        themeButton.textContent = "☀️ Light Mode";
        localStorage.setItem(
            "theme",
            "dark"
        );
    }

    // LIGHT MODE FUNCTION
    function enableLightMode() {
        document.body.classList.remove("dark-mode");
        themeButton.textContent = "🌙 Dark Mode";
        localStorage.setItem(
            "theme",
            "light"
        );
    }

    // RESTORE SAVED THEME
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme === "dark") {
        enableDarkMode();
    } else {
        enableLightMode();
    }

    // THEME BUTTON CLICK
    themeButton.addEventListener("click", function () {
        if (
            document.body.classList.contains("dark-mode")
        ) {
            enableLightMode();
        } else {
            enableDarkMode();
        }
    });
    
    // SETTINGS PAGE RADIO BUTTONS
    const themeRadios =
        document.querySelectorAll(
            'input[name="theme"]'
        );
    themeRadios.forEach(function (radio) {
        radio.addEventListener("change", function () {
            const text = radio.parentElement.innerText.toLowerCase();
            if (text.includes("dark")) {
                enableDarkMode();
            } else {
                enableLightMode();
            }
        });
    });
});