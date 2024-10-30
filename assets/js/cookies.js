
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
        // Révoquer le consentement aux cookies
        document.getElementById("revokeCookies").addEventListener("click", function(event) {
            event.preventDefault(); // Empêche le lien de recharger la page
            eraseCookie("cookieConsent"); // Efface le cookie
            alert("Votre consentement aux cookies a été réinitialisé. La prochaine fois que vous visiterez cette page, vous pourrez refaire votre choix.");
            location.reload(); // Rafraîchit la page pour afficher la modale
        });

        // Fonction pour effacer un cookie
        function eraseCookie(name) {
            document.cookie = name + '=; Max-Age=-99999999;';
        }
    });
