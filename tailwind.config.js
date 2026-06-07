import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    // ??? SAFELIST: บังคับให้ Tailwind สร้างสีสำหรับ 9 สิทธิ์เสมอ ไม่ว่าจะมีการเรียกใช้ใน Blade หรือไม่
    safelist: [
        {
            pattern: /^(bg|text|border|ring)-(gray|slate|green|amber|sky|purple|orange|blue|pink)-(600|700|800|900)$/,
        },
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