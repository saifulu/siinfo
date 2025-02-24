/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require("daisyui")
    ],
    // Konfigurasi tema DaisyUI (opsional)
    daisyui: {
        themes: [
            {
                light: {
                    ...require("daisyui/src/theming/themes")["light"],
                    primary: "#4F46E5",    // indigo-600
                    secondary: "#6B7280",  // gray-500
                    accent: "#37CDBE",
                    neutral: "#3D4451",
                    "base-100": "#FFFFFF",
                    "base-200": "#F3F4F6",
                    "base-300": "#E5E7EB",
                },
            },
        ],
    },
};
