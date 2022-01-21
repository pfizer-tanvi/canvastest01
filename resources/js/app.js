import * as bootstrap from 'bootstrap';

window.bootstrap = bootstrap;

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-bs-toggle="popover"]').forEach((element) => bootstrap.Popover(element));
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((element) => bootstrap.Tooltip(element));
});
