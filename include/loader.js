(function() {
    // Funkcja do załadowania pliku JS
    function loadScript(src, callback) {
        const script = document.createElement('script');
        script.src = src;
        script.type = 'text/javascript';
        script.onload = callback;
        script.onerror = function() {
            console.error('Błąd ładowania skryptu:', src);
        };
        document.head.appendChild(script);
    }

    // Funkcja do załadowania arkusza CSS
    function loadCSS(href) {
        const link = document.createElement('link');
        link.href = href;
        link.rel = 'stylesheet';
        link.type = 'text/css';
        document.head.appendChild(link);
    }

    // Lista plików do załadowania
    const dependencies = {
        scripts: [
            '../core/loader/products-loader.js',
            '../assets/js/jquery-3.7.1.min.js',
            '../assets/js/menu.js',
            '../assets/js/modal.js'
        ],
        styles: [
            '../assets/css/hero.css',
            '../assets/css/main.css',
            '../assets/css/modal.css',
            '../assets/css/nav.css',
            '../assets/css/products.css'
        ]
    };

    // Ładowanie plików CSS
    dependencies.styles.forEach(function(style) {
        loadCSS(style);
    });

    // Ładowanie plików JS po załadowaniu poprzednich
    let scriptIndex = 0;
    function loadNextScript() {
        if (scriptIndex < dependencies.scripts.length) {
            loadScript(dependencies.scripts[scriptIndex], function() {
                scriptIndex++;
                loadNextScript();
            });
        } else {
            console.log('Wszystkie skrypty zostały załadowane.');
        }
    }

    loadNextScript();
})();
