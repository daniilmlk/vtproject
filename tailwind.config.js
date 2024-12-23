import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
module.exports = {
    theme: {
      extend: {
        colors: {
          primary: '#4C9EFF',   // A lighter blue
          secondary: '#f0f0f0',  // Light gray background
          dark: '#1A202C',       // Dark text for posts
          accent: '#FF7F50',     // Coral accent color for buttons
        }
      }
    }
  }
  
