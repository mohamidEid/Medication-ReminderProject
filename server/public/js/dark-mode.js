// Dark Mode - Super Simple Version
(function () {
    'use strict';

    // Apply dark mode on page load
    if (localStorage.darkMode === 'true') {
        document.documentElement.classList.add('dark');
    }

    // Toggle function
    window.toggleDark = function () {
        document.documentElement.classList.toggle('dark');
        localStorage.darkMode = document.documentElement.classList.contains('dark');
    };
})();
