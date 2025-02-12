// Funkcja do ładowania menu nawigacyjnego
fetch('../core/config/nav-config.json')
  .then(response => response.json())  // Pobranie danych JSON
  .then(data => {
    console.log('Załadowana konfiguracja menu:', data); // Logowanie pobranych danych

    // Ustawienie logo
    const logoElement = document.querySelector('.logo');
    if (logoElement && data.logo) {
      logoElement.textContent = data.logo;
    }

    // Pobranie elementu menu
    const menuElement = document.querySelector('.menu');
    if (menuElement && data.menu) {
      menuElement.innerHTML = ''; // Wyczyść menu przed dodaniem nowych elementów

      // Iteracja po elementach menu i dynamiczne dodanie linków
      data.menu.forEach(item => {
        const li = document.createElement('li');
        const a = document.createElement('a');
        a.textContent = item.text;
        a.href = item.href;
        li.appendChild(a);
        menuElement.appendChild(li);
      });
    }
  })
  .catch(error => {
    console.error('Błąd ładowania konfiguracji menu:', error);
  });
