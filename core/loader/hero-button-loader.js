// Funkcja do ładowania przycisku hero
fetch('../core/config/hero-config.json')
  .then(response => response.json())  
  .then(data => {
    console.log('Załadowane dane dla hero-button:', data);

    const section = data.find(item => item["section-id"] === "hero-button");
    if (section && section.text && section.href) {
      const buttonElement = document.querySelector('.hero-button');
      const linkElement = document.querySelector('.hero-button-link');
      if (buttonElement && linkElement) {
        buttonElement.textContent = section.text;
        linkElement.setAttribute('href', section.href);
      }
    }
  })
  .catch(error => {
    console.error('Błąd ładowania hero-button:', error);
  });
