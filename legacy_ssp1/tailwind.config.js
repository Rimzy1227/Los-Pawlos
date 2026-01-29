module.exports = {
  content: [
    "./app/Views/**/*.php",
    "./public/**/*.php",
    "./src/**/*.css"
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          50: '#fff8f2',
          100: '#fdebd6',
          500: '#ff7a18',
        }
      },
      fontFamily: {
        display: ['Inter', 'sans-serif']
      }
    },
  },
  plugins: [],
}
