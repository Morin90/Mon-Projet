
    document.addEventListener("DOMContentLoaded", function() {
        // Vérifie si le cookie "cookieConsent" existe
        if (!getCookie("cookieConsent")) {
            // Affiche la modale si le cookie n'existe pas
            document.getElementById("cookieModal").style.display = "block";
        }

        // Gestion du clic sur le bouton "Accepter"
        document.getElementById("acceptCookies").addEventListener("click", function() {
            setCookie("cookieConsent", "accepted", 30); // Durée de 30 jours
            document.getElementById("cookieModal").style.display = "none";
        });

        // Gestion du clic sur le bouton "Refuser"
        document.getElementById("rejectCookies").addEventListener("click", function() {
            setCookie("cookieConsent", "rejected", 30); // Durée de 30 jours
            document.getElementById("cookieModal").style.display = "none";
        });

        // Fonction pour définir un cookie
        function setCookie(name, value, days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            const expires = "expires=" + date.toUTCString();
            document.cookie = name + "=" + value + ";" + expires + ";path=/";
        }

        // Fonction pour récupérer un cookie
        function getCookie(name) {
            const value = "; " + document.cookie;
            const parts = value.split("; " + name + "=");
            if (parts.length === 2) return parts.pop().split(";").shift();
        }
    });
