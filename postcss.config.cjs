module.exports = {
  plugins: [
    require("@fullhuman/postcss-purgecss")({
      // 1. Dile a Vite dónde están tus clases de Bootstrap en PHP
      content: ["./app/views/**/*.php", "./static/js/**/*.js", "./index.php"],
      // 2. Protege las clases dinámicas de Bootstrap
      safelist: [/modal/, /fade/, /show/, /collapse/, /dropdown/],
      // 3. Extractor para que no se confunda con caracteres especiales
      defaultExtractor: (content) => content.match(/[\w-/:]+(?<!:)/g) || [],
    }),
  ],
};
