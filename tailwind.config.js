/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        // Sobrescreve os breakpoints originais para o Padrão gov.br
        screens: {
            'sm': '576px',
            'md': '768px',
            'lg': '992px',
            'xl': '1200px',
        },
        extend: {
            // Base Normativa: Tipografia estrita do gov.br
            fontFamily: {
                sans: ['Open Sans', 'sans-serif'],
                heading: ['Montserrat', 'sans-serif'],
            },
            colors: {
                // Aqui você pode mapear futuramente as cores do gov.br
                // govblue: '#1351B4',
                // govyellow: '#F8E800',
            }
        },
    },
    plugins: [],
}