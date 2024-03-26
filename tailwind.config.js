import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    // I do this because: https://stackoverflow.com/questions/75440072/tailwindcss-styles-not-rendered-when-applied-dynamically-in-nextjs
    safelist: [
        "bg-green-700",
        "bg-blue-700",
        "bg-red-700",
        "hover:bg-green-800",
        "hover:bg-blue-800",
        "hover:bg-red-800",
        "text-blue-500",
        "text-red-500",
        "border-blue-500",
        "border-red-500",
        "focus:ring-red-500",
        "w-[400px]",
        "h-[40px]",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
