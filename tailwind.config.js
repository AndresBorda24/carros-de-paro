/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'selector',
    content: [
        "./index.html",
        "./templates/index.php",
        "./src/*/.{js,vue}",
    ],
    theme: {
        extend: {},
    },
    plugins: [],
}