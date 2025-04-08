import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flyonui/dist/js/*.js",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [require("flyonui"), require("flyonui/plugin")],
    flyonui: {
        themes: [
            {
                light: {
                    ...require("flyonui/src/theming/themes")["light"],
                    primary: "#20783d",
                    "primary-content": "#e5ffec",
                },
            },
            {
                dark: {
                    ...require("flyonui/src/theming/themes")["dark"],
                    primary: "#20783d",
                    "primary-content": "#e5ffec",
                },
            },
        ],
    },
    darkMode: ["class", '[data-theme="dark"]'],
};
