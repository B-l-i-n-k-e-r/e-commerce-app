/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['arial', 'sans-serif'], // Make sure 'gothic' is imported somewhere!
      },
      fontSize: {
        'xxl': '100px', // Custom font size
      },
    },
  },
  plugins: [],
}
