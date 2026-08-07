import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#2C3E50',
                accent: '#27AE60',
                'accent-hover': '#219653',
                'bg-light': '#F8F9FA',
                'card-bg': '#FFFFFF',
                'sidebar-bg': '#FDFDFD',
                warning: '#F2C94C',
                danger: '#EB5757',
            },
        },
    },

    plugins: [forms],
};
