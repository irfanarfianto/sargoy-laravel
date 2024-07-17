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
                sans: ["Roboto", "Open Sans", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    daisyui: {
        themes: [
            {
                mytheme: {
                    primary: "#046aff",
                    secondary: "#004eff",
                    accent: "#0000ff",
                    neutral: "#171d45",
                    "base-100": "#ebecf2",
                    info: "#25A3FC",
                    success: "#70CE29",
                    warning: "#FFBA3A",
                    error: "#FC3A3A",
                    blue: "#26355D",
                },
            },
        ],
    },

    plugins: [daisyui, forms],
};
