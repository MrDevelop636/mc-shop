// Funkcja do ładowania podtytułu hero
fetch('../core/config/hero-config.json')
  .then(response => response.json())  
  .then(data => {
    console.log('Załadowane dane dla hero-subtitle:', data);

    const section = data.find(item => item["section-id"] === "hero-subtitle");
    if (section && section.text) {
      const element = document.querySelector('.hero-subtitle');
      if (element) {
        element.textContent = section.text;
        if (section['font-color']) element.style.color = section['font-color'];
        if (section['font-size']) element.style.fontSize = `${section['font-size']}px`;
        if (section.font) element.style.fontFamily = section.font;
      }
    }
  })
  .catch(error => {
    console.error('Błąd ładowania hero-subtitle:', error);
  });
