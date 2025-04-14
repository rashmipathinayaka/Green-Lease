
// Select all necessary elements
const form = document.getElementById('signup-form');
const inputs = form.querySelectorAll('input[required]');
const roleInputs = form.querySelectorAll('input[name="role"]');
const progressBar = document.querySelector('.progress-bar');
const passwordInput = document.getElementById('password');
const confirmPasswordInput = document.getElementById('confirm-password');

function checkPasswordsMatch() {
    if (passwordInput.value !== confirmPasswordInput.value) {
        confirmPasswordInput.setCustomValidity("Passwords don't match");
        return false;
    } else {
        confirmPasswordInput.setCustomValidity('');
        return true;
    }
}

function updateProgress() {
    const total = inputs.length;
    let filled = 0;
    
    // Count filled text/email inputs
    inputs.forEach(input => {
        if (input.type !== 'radio' && input.type !== 'password' && input.value.length > 0) {
            filled++;
        }
    });
    
    // Check if passwords match and are filled
    if (passwordInput.value.length > 0 && confirmPasswordInput.value.length > 0) {
        if (checkPasswordsMatch()) {
            filled += 2; // Count both password fields
        }
    }
    
    // Check if any role is selected
    const roleSelected = Array.from(roleInputs).some(radio => radio.checked);
    if (roleSelected) {
        filled++;
    }
    
    const progress = (filled / total) * 100;
    progressBar.style.setProperty('--progress', `${progress}%`);
}

// Add event listeners to all inputs
inputs.forEach(input => {
    input.addEventListener('input', updateProgress);
});

// Add event listeners to role radio buttons
roleInputs.forEach(radio => {
    radio.addEventListener('change', updateProgress);
});

// Add specific listeners for password fields
passwordInput.addEventListener('input', () => {
    checkPasswordsMatch();
    updateProgress();
});

confirmPasswordInput.addEventListener('input', () => {
    checkPasswordsMatch();
    updateProgress();
});

// Add form submit handler
form.addEventListener('submit', (e) => {
    if (!checkPasswordsMatch()) {
        e.preventDefault();
        alert("Passwords don't match!");
        return false;
    }
});

// Initial progress calculation
updateProgress();

// Simple password strength indicator
// const passwordInput = document.getElementById('password');
// const strengthBar = document.querySelector('.password-strength');

// passwordInput.addEventListener('input', function() {
//     const value = this.value;
//     let strength = 0;
    
//     if(value.length >= 8) strength += 25;
//     if(value.match(/[A-Z]/)) strength += 25;
//     if(value.match(/[0-9]/)) strength += 25;
//     if(value.match(/[^A-Za-z0-9]/)) strength += 25;

//     strengthBar.style.setProperty('--strength', `${strength}%`);
// });

function validateSriLankanNIC(nic) {
    // Remove any whitespace
    nic = nic.trim();
    
    // Old NIC format (9 digits + V/X)
    const oldNICRegex = /^[0-9]{9}[VvXx]$/;
    
    // New NIC format (12 digits)
    const newNICRegex = /^[0-9]{12}$/;
    
    // Check if it matches either format
    if (!oldNICRegex.test(nic) && !newNICRegex.test(nic)) {
        return {
            isValid: false,
            message: "Invalid NIC format"
        };
    }
    
    // Validate old NIC format
    if (nic.length === 10) {
        // Extract year from first two digits
        const year = parseInt(nic.substring(0, 2));
        // Extract days from next three digits
        const days = parseInt(nic.substring(2, 5));
        
        // Validate days
        if (days > 866 || days < 1) {
            return {
                isValid: false,
                message: "Invalid days value in NIC"
            };
        }
        
        // Extract gender (days > 500 indicates female)
        const gender = days > 500 ? "Female" : "Male";
        const actualDays = days > 500 ? days - 500 : days;
        
        // Validate actual days (should not exceed 366)
        if (actualDays > 366) {
            return {
                isValid: false,
                message: "Invalid days value in NIC"
            };
        }
        
        return {
            isValid: true,
            format: "old",
            yearOfBirth: 1900 + year,
            gender: gender,
            message: "Valid old format NIC"
        };
    }
    
    // Validate new NIC format
    if (nic.length === 12) {
        // Extract year from first four digits
        const year = parseInt(nic.substring(0, 4));
        // Extract days from next three digits
        const days = parseInt(nic.substring(4, 7));
        
        // Validate year
        if (year < 1900 || year > new Date().getFullYear()) {
            return {
                isValid: false,
                message: "Invalid year in NIC"
            };
        }
        
        // Validate days
        if (days > 866 || days < 1) {
            return {
                isValid: false,
                message: "Invalid days value in NIC"
            };
        }
        
        // Extract gender (days > 500 indicates female)
        const gender = days > 500 ? "Female" : "Male";
        const actualDays = days > 500 ? days - 500 : days;
        
        // Validate actual days (should not exceed 366)
        if (actualDays > 366) {
            return {
                isValid: false,
                message: "Invalid days value in NIC"
            };
        }
        
        return {
            isValid: true,
            format: "new",
            yearOfBirth: year,
            gender: gender,
            message: "Valid new format NIC"
        };
    }
}