```javascript
// COVID-19 Website - JavaScript Validation

function validateEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

function validateMobile(mobile) {
    const mobilePattern = /^[6-9]\d{9}$/;
    return mobilePattern.test(mobile);
}

function validatePassword(password) {
    const passwordPattern =
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    return passwordPattern.test(password);
}

function validateRegistration(email, mobile, password) {
    if (!validateEmail(email)) {
        return "Please enter a valid email address.";
    }

    if (!validateMobile(mobile)) {
        return "Enter a valid 10-digit Indian mobile number.";
    }

    if (!validatePassword(password)) {
        return "Password must have 8 characters, uppercase, lowercase, number and special character.";
    }

    return "All fields are valid!";
}

console.log(validateRegistration(
    "student@example.com",
    "9876543210",
    "Student@123"
));
```
