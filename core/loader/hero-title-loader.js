// Funkcja do ładowania tytułu hero
fetch('../core/config/hero-config.json')
  .then(response => response.json())  
  .then(data => {
    console.log('Załadowane dane dla hero-title:', data);

    const section = data.find(item => item["section-id"] === "hero-title");
    if (section && section.text) {
      const element = document.querySelector('.hero-title');
      if (element) {
        element.textContent = section.text;
        if (section['font-color']) element.style.color = section['font-color'];
        if (section['font-size']) element.style.fontSize = `${section['font-size']}px`;
        if (section.font) element.style.fontFamily = section.font;
      }
    }
  })
  .catch(error => {
    console.error('Błąd ładowania hero-title:', error);
  });
