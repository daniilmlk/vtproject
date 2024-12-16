import { defineConfig } from 'vite';
import path from 'path';
import laravel from 'laravel-vite-plugin';
export default defineConfig({
  resolve: {
    alias: {
      '@': path.resolve(__dirname, './resources'),
    },
  },
  build: {
    outDir: 'public',
  },
  plugins: [
    laravel({
        input: [
            'resources/css/app.css',
            'resources/js/app.js',
            'resources/css/custom.css' // Include custom.css
        ],
        refresh: true,
    }),
],
});
