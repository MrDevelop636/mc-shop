// Funkcja do ładowania danych z JSON
fetch('../core/config/pages/main/config.json')
  .then(response => response.json())  // Odbierz dane w formacie JSON
  .then(data => {
    console.log('Załadowane dane:', data); // Logowanie danych JSON

    // Funkcja pomocnicza do aktualizowania elementów
    function updateElement(sectionId, selector) {
      const section = data.find(item => item["section-id"] === sectionId);
      if (section && section.text) {
        const element = document.querySelector(selector);
        if (element) {
          element.textContent = section.text;
          if (section['font-color']) element.style.color = section['font-color'];
          if (section['font-size']) element.style.fontSize = `${section['font-size']}px`;
          if (section.font) element.style.fontFamily = section.font;
        }
      }
    }

    // Ładowanie tytułu hero
    updateElement('hero-title', '.hero-title');

    // Ładowanie podtytułu hero
    updateElement('hero-subtitle', '.hero-subtitle');

    // Ładowanie przycisku hero
    const heroButton = data.find(item => item["section-id"] === "hero-button");
    console.log('Hero button data:', heroButton); // Logowanie danych przycisku
    if (heroButton && heroButton.text && heroButton.href) {
      const buttonElement = document.querySelector('.hero-button');
      const linkElement = document.querySelector('.hero-button-link');
      if (buttonElement && linkElement) {
        buttonElement.textContent = heroButton.text;
        linkElement.setAttribute('href', heroButton.href); // Ustawienie href na link
      }
    }
  })
  .catch(error => {
    console.error('Błąd ładowania danych JSON:', error);
  });
