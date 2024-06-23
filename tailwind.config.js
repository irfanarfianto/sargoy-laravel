import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
const daisyui = require("daisyui");

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    daisyui: {
        themes: [
            {
                mytheme: {
                    primary: "#9700ff",
                    secondary: "#004eff",
                    accent: "#0000ff",
                    neutral: "#312620",
                    "base-100": "#fff9fd",
                    info: "#00edff",
                    success: "#00d088",
                    warning: "#ffa400",
                    error: "#e80015",
                    blue: "#26355D",
                },
            },
        ],
    },

    plugins: [daisyui, forms],
};
