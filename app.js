'use strict';

const registrationForm = document.querySelector('#registerForm');

if (registrationForm) {
    const password = registrationForm.querySelector('#password');
    const confirmation = registrationForm.querySelector('#confirm_password');

    const validatePasswordMatch = () => {
        confirmation.setCustomValidity(
            confirmation.value === password.value ? '' : 'Passwords do not match.'
        );
    };

    password.addEventListener('input', validatePasswordMatch);
    confirmation.addEventListener('input', validatePasswordMatch);
    registrationForm.addEventListener('submit', (event) => {
        validatePasswordMatch();
        if (!registrationForm.checkValidity()) {
            event.preventDefault();
            registrationForm.reportValidity();
        }
    });
}
