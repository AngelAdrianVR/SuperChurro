const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        screens: {
            'xs': '390px',
            ...defaultTheme.screens,
          },
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#F07209',
                primarylight: '#C9FDE4',
                secondary: '#FFD703',
                secondarylight: '#474747',
                gray1: '#666666',
                gray2: '#97989A',
                gray3: '#BEBFC1',
                gray4: '#D9D9D9',
                gray5: '#F2F2F2',
                gray6: '#CCCCCC',
            }
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
