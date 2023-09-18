const colors = require('tailwindcss/colors');

module.exports = {
    content: [
        "./config/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"
    ],
    theme: {
        extend: {},
        colors: {
            primary: colors.sky,
        },
    },
    darkMode: 'class',
    plugins: [
        require('flowbite/plugin'),
    ],
}
