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
                primary: {
                    50: '#EFF6FF',
                    100: '#DBEAFE',
                    500: '#3B82F6',
                    600: '#2563EB',
                    700: '#2563EB',
                },
                secondary: {
                    50: '#FFF7ED',
                    100: '#FFEDD5',
                    500: '#F97316',
                    600: '#FB923C',
                    700: '#EA580C',
                },
                accent: {
                    50: '#EFF6FF',
                    500: '#2563EB',
                    600: '#1D4ED8',
                    700: '#1E40AF',
                },
                highlight: {
                    50: '#FFF7ED',
                    500: '#FB923C',
                    600: '#F97316',
                },
            },
        },
    },

    plugins: [forms],
};

