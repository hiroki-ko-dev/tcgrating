import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
  plugins: [
    laravel([
      'resources/css/main.css',
      'resources/scss/post/post-show.scss',
      'resources/scss/post/post-index.scss',
      'resources/scss/blog/blog-show.scss',
      'resources/scss/blog/blog-index.scss',
      'resources/js/main.jsx',
      'resources/js/resume/Resume.jsx',
      'resources/js/post/DeckPreview.tsx',
    ]),
    react(),
  ],
  build: {
    rollupOptions: {
      output: {
        // ビルド後の処理
        assetFileNames: (assetInfo) => {
          // ckeditorのためにファイル名を確定させる処理
          if (assetInfo.name.includes('blog-show')) {
            return 'assets/blog-show.css'; // ハッシュを含まないファイル名
          }
          return 'assets/[name]-[hash][extname]'; // 通常のファイル名フォーマット
        }
      }
    }
  }
});