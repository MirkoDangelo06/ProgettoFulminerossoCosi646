document.addEventListener("DOMContentLoaded", () => {
    const splashScreen = document.getElementById('splash-screen');
    const video = document.getElementById('splash-video');
    
    // Forza il caricamento del video
    video.load();
    
    // Funzione per nascondere lo splash screen
    const hideSplash = () => {
        splashScreen.classList.add('fade-out');
        
        // Rimuovi completamente l'elemento dopo la transizione
        setTimeout(() => {
            splashScreen.remove();
        }, 500);
    };
    
    // Prova a riprodurre il video
    const playPromise = video.play();
    
    if (playPromise !== undefined) {
        playPromise.then(() => {
            // Video riprodotto con successo
            video.addEventListener('ended', hideSplash);
            
            // Backup: nascondi dopo 2.5s anche se il video non finisce
            setTimeout(hideSplash, 2500);
        })
        .catch(error => {
            // Fallback se la riproduzione automatica non è permessa
            console.log('Autoplay non permesso:', error);
            hideSplash();
        });
    }
    
    // Backup aggiuntivo: nascondi dopo 3s in ogni caso
    setTimeout(hideSplash, 3000);
});