document.addEventListener("DOMContentLoaded", function () {
    var form = document.getElementById("jobForm");
    form.addEventListener("submit", validateForm);
});

function validateName() {
    var name = document.getElementById("myName").value;
    if (name.trim() === "") {
        return "Name cannot be empty.";
    }
    if (!/^[a-zA-Z .-]+$/.test(name)) {
        return "Name must contain only alphabet characters and spaces.";
    }
    return "";
}

function validateEmail() {
    var email = document.getElementById("myEmail").value;
    if (email.trim() === "") {
        return "Email cannot be empty.";
    }
    if (!/^[\w.-]+@(\w+\.){1,3}\w{2,3}$/.test(email)) {
        return "E-mail must be username@domain.ext (last extension 2-3 characters).";
    }
    return "";
}

function validateDate() {
    var date = document.getElementById("startDate").value;
    if (date === "") {
        return "Start date cannot be empty.";
    }
    var today = new Date();
    today.setHours(0, 0, 0, 0);
    var DateMax = new Date()
    DateMax.setFullYear(DateMax.getFullYear() + 10);    
    if (new Date(date) <= today) {
        return "Start date cannot be today or in the past.";
    }
    if (new Date(date) >= DateMax) {
        return "Start date cannot be 10 years from now.";
    }
    return "";
}

function validateExperience() {
    var exp = document.getElementById("myExperience").value;
    if (exp.trim() === "") {
        return "Experience cannot be empty.";
    }
    return "";
}

function validateForm(event) {
    var errors = [];

    var nameError = validateName();
    if (nameError) errors.push(nameError);

    var emailError = validateEmail();
    if (emailError) errors.push(emailError);

    var dateError = validateDate();
    if (dateError) errors.push(dateError);

    var expError = validateExperience();
    if (expError) errors.push(expError);

    if (errors.length > 0) {
        alert(errors.join("\n\n"));
        event.preventDefault();
        return false;
    }
    return true;
}