import { defineConfig } from "vite";

export default defineConfig({
  build: {
    outDir: "./dist",
    assetsDir: "",
    rollupOptions: {
      output: {
        entryFileNames: "video.js",
        // chunkFileNames: "[name].[ext]",
        // assetFileNames: "[name].[ext]",
      },
    },
  },
});
