document.addEventListener("DOMContentLoaded", () => {
    const video = document.querySelector('video'); // Seleziona il tuo elemento video
    video.addEventListener('loadedmetadata', () => {
        // Avvia il timer solo quando il video è pronto
        setTimeout(() => {
            document.getElementById('splash-screen').classList.add('fade-out');
        }, 5000);
    });

    video.addEventListener('ended', () => {
        splashScreen.classList.add('fade-out');
    });
});