import Alpine from "alpinejs";

window.Alpine = Alpine;

document.addEventListener("alpine:init", function() {
    Alpine.data("vite", () => ({
        message: "Funciona",

        showMessage() {
            alert(this.message);
        }
    }));
});

document.addEventListener("DOMContentLoaded", function() {
    Alpine.start();
});
