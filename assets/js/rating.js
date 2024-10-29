// selection des etoiles
const stars = document.querySelectorAll('.fa-star');
// ajout d'event pour chaque etoile
stars.forEach(star => {
    // ajout d'event lors du survol sur l'etoile
    star.addEventListener('mouseover', (event) => {
        // recuperation de la valeur de l'etoile
        const value = star.getAttribute('data-value');
        // changement de la couleur de l'etoile
        star.style.color = star.getAttribute('data-value') <= value ? 'gold' : '#ccc';
        // instanciation des headers
        const headers = new Headers();
        headers.append("Content-Type", "application/json");
        // ajout d'event lors du click
        event.target.addEventListener('click', async (event) => {
            // Convertis la liste des enfants (étoiles) de l'élément parent en tableau, puis trouve l'index de l'étoile cliqué
            const note = Array.from(event.target.parentNode.children).findIndex(child => child === event.target)
            // recuperation de l'id de l'element parent (velo)
            const veloId = event.target.parentNode.dataset.veloId
            // envoi de la requête asynchrone pour soumettre la note en variable dans l'URL
            await fetch(`https://magasin-velo-kraken-7fcdb570f12c.herokuapp.com/note?note=${note}&veloId=${veloId}&userId=${event.target.parentNode.dataset.userId}`, {
                method: 'GET',
                headers: headers
                // traitement de la réponse, convertion en JSON
            }).then(response => response.json()).then(data => {
                // si le message est 'added', on rafraichit la page
                if (data.message === 'added') {
                    location.reload();
                }
            })
        });
    });

    // ajout d'event lors de la sortie de la souris
    star.addEventListener('mouseout', () => {
        if (!star.dataset.note) {
            const value = star.getAttribute('data-value');
            star.style.color = star.getAttribute('data-value') <= value ? '#000000' : 'gold';
        }
    });

});
/*ligne 21 /  await fetch(`http://localhost:8000/note?note=${note}&veloId=${veloId}&userId=${event.target.parentNode.dataset.userId} en mode developpement*/
/*await fetch(`https://magasin-velo-kraken-7fcdb570f12c.herokuapp.com/note?note=${note}&veloId=${veloId}&userId=${event.target.parentNode.dataset.userId}` mode production*/