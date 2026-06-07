import defaultTheme from 'tailwindcss/defaultTheme';

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
                anuphan: ['Anuphan', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                nature: {
                    50:  '#effefa',
                    100: '#c8f7ec',
                    200: '#96efd8',
                    300: '#5ddebf',
                    400: '#32c9a7',
                    500: '#20a98e',
                    600: '#1a8a74',
                    700: '#176e5e',
                    800: '#15594d',
                    900: '#134a41',
                    950: '#0a2e28',
                },
                ncdblue: {
                    50:  '#e6f0ff',
                    100: '#bdd5ff',
                    200: '#8db8ff',
                    300: '#5a98ff',
                    400: '#3378ff',
                    500: '#1556f0',
                    600: '#0d41d7',
                    700: '#1034af',
                    800: '#142d89',
                    900: '#162a6f',
                    950: '#101b47',
                },
            },
        },
    },

    safelist: [
        {
            pattern: /^(bg|text|border|ring|from|to|via|shadow)-(gray|slate|green|amber|sky|purple|orange|blue|pink|nature|ncdblue)-(50|100|200|300|400|500|600|700|800|900|950)$/,
        },
        'lg:ml-64',
        'lg:ml-20',
    ],

    plugins: [],
};