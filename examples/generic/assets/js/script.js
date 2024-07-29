const setup_elements = (root_el) => {
    const root = root_el instanceof Element
        ? root_el
        : document;
    root.querySelectorAll('[data-flatpickr]').forEach((element) => {
        flatpickr(element, {
            maxDate: 'today'
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    setup_elements();
});