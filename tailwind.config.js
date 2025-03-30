/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './*.php',
    './template-parts/**/*.php',
    './inc/**/*.php',
    './js/**/*.js',
    './templates/**/*.php',
    './blocks/**/*.php',
    './partials/**/*.php'
  ],
  theme: {
    extend: {
      colors: {
        'primary': '#0073aa',
        'secondary': '#005177',
      },
      fontFamily: {
        'sans': ['Helvetica Neue', 'Arial', 'sans-serif'],
      },
    },
  },
  plugins: [],
} 