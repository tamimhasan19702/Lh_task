/** @format */

module.exports = {
  content: [
    "./public/**/*.php",
    "./admin/**/*.php",
    // Add any other directories containing PHP files
  ],
  theme: {
    extend: {
      fontFamily: {
        montserrat: ["Montserrat", "sans-serif"],
      },
      colors: {
        primary: "#7f56d9",
        secondary: "#00183D",
        background: "#FFFFFF",
        text: "#D4DDF2",
        secondaryText: "#B8B8B8",
        highlight: "#E4E4E4",
      },
      fontSize: {
        heading1: "36px",
        heading2: "28px",
        tag: "13px",
        button: "16px",
        paragraph1: "18px",
        paragraph2: "14px",
      },
      lineHeight: {
        heading: "115%",
        tag: "130%",
        normal: "100%",
        paragraph: "130%",
      },
    },
  },
};
