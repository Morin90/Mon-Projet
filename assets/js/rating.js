
const stars = document.querySelectorAll('.fa-star');
stars.forEach(star => {
        star.addEventListener('mouseover', (event) => {
            const value = star.getAttribute('data-value');
            star.style.color = star.getAttribute('data-value') <= value ? 'gold' : '#ccc';
            const headers = new Headers();
            headers.append("Content-Type", "application/json");
            event.target.addEventListener('click', async (event) => {
                const note = Array.from(event.target.parentNode.children).findIndex(child => child === event.target)
                const veloId = event.target.parentNode.dataset.veloId
                await fetch(`http://localhost:8000/note?note=${note}&veloId=${veloId}&userId=${event.target.parentNode.dataset.userId}`, {
                    method: 'GET',
                    headers: headers
                }).then(response => response.json()).then(data => {
                    if (data.message === 'added') {
                        location.reload();
                    }
                })
            });
        });
    

    star.addEventListener('mouseout', () => {
        if (!star.dataset.note) {
            const value = star.getAttribute('data-value');
            star.style.color = star.getAttribute('data-value') <= value ? '#000000' : 'gold';
        }
    });

});