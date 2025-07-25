import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography'; // إضافة Plugin للنصوص

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js', // إضافة ملفات JavaScript
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans], // استخدام خط Figtree
            },
            colors: {
                'primary': '#3490dc', // لون أساسي
                'secondary': '#ffed4a', // لون ثانوي
                'success': '#38c172', // لون النجاح
                'danger': '#e3342f', // لون الخطأ
                'warning': '#f6993f', // لون التحذير
                'info': '#6cb2eb', // لون المعلومات
            },
            spacing: {
                '72': '18rem', // إضافة مسافة مخصصة
                '84': '21rem',
                '96': '24rem',
            },
            boxShadow: {
                'custom': '0 4px 6px -1px rgba(0, 0, 0, 0.2), 0 2px 4px -1px rgba(0, 0, 0, 0.06)', // ظل مخصص
            },
        },
    },

    plugins: [
        forms, // Plugin للنماذج
        typography, // Plugin للنصوص
    ],
};