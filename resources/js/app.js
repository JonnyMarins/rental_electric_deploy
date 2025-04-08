import "./bootstrap";
import "flyonui/flyonui";

// Gestione del tema chiaro/scuro
document.addEventListener("DOMContentLoaded", () => {
    // Recupera il tema corrente dall'attributo data-theme
    const currentTheme = document.documentElement.getAttribute("data-theme") || "light";

    // Imposta lo stato dello switch in base al tema corrente
    const themeSwitch = document.getElementById("theme-switch");
    if (themeSwitch) {
        // Aggiungi una classe per disabilitare temporaneamente le transizioni
        themeSwitch.classList.add("no-transition");

        // Imposta lo stato dello switch senza animazione
        themeSwitch.checked = currentTheme === "dark";

        // Forza un reflow per applicare immediatamente lo stato
        themeSwitch.offsetHeight;

        // Rimuovi la classe dopo un breve ritardo per ripristinare le transizioni
        setTimeout(() => {
            themeSwitch.classList.remove("no-transition");
        }, 50);

        // Aggiungi event listener per il cambio tema
        themeSwitch.addEventListener("change", function () {
            const newTheme = this.checked ? "dark" : "light";
            document.documentElement.setAttribute("data-theme", newTheme);
            localStorage.setItem("theme", newTheme);
        });
    }
});
