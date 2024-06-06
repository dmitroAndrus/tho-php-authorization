document.addEventListener('DOMContentLoaded', () => {
    const birthday_input = document.getElementById("sign-up-birthday");
    if (birthday_input) {
        flatpickr(birthday_input, {
            maxDate: 'today'
        });
    }
});