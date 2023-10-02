import preset from './vendor/filament/support/tailwind.config.preset'
const colors = require('tailwindcss/colors');

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"
    ],
    darkMode: 'class',
    plugins: [
        require('flowbite/plugin')
    ],
}
