import { defineConfig } from "vite";

export default defineConfig({
  build: {
    outDir: "static/dist",
    rollupOptions: {
      input: {
        // Vite entrará aquí y seguirá las migas de pan de los "import"
        admin: "./static/js/admin-entry.js",
        public: "./static/js/public-entry.js",
      },
      output: {
        // Los JS irán a dist/js/admin.js y dist/js/public.js
        entryFileNames: "js/[name].js",
        // Los CSS irán a dist/css/admin.css y dist/css/public.css
        assetFileNames: "css/[name].[ext]",
      },
    },
  },
});
