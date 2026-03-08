import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import basicSsl from "@vitejs/plugin-basic-ssl";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        basicSsl(),
    ],
    server: {
        host: "0.0.0.0",
        https: true,
        cors: true,
        origin: "https://localhost:5173",
        hmr: {
            host: "localhost",
        },
        allowedHosts: [".ngrok-free.dev"],
    },
});
