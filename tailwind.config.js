import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['"Zilla Slab"', 'Newsreader', 'Georgia', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                // adding a custom brand color for editorial feel
                editorial: {
                    50: '#f6f6f6',
                    100: '#e7e7e7',
                    900: '#1a1a1a',
                },
            },
        },
    },

    plugins: [forms, typography],
};
