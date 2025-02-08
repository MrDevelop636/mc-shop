
  fetch('./core/db/products.json')
    .then(response => {
      // Sprawdzamy, czy odpowiedź jest poprawna (status 200)
      if (!response.ok) {
        throw new Error('Błąd ładowania pliku JSON: ' + response.status);
      }
      return response.json();
    })
    .then(data => {
      console.log('Dane załadowane poprawnie:', data);

      // Kontener na karty produktów
      const container = document.getElementById('produkty-container');

      // Iteracja po danych i tworzenie kart produktów
      data.forEach(produkt => {
        // Tworzenie elementu karty
        const card = document.createElement('div');
        card.classList.add('product-card');

        // Tworzenie obrazu
        const img = document.createElement('img');
        img.src = produkt.obraz;
        img.alt = produkt.nazwa;

        // Tworzenie nagłówka
        const h3 = document.createElement('h3');
        h3.textContent = produkt.nazwa;

        // Tworzenie opisu
        const p = document.createElement('p');
        p.textContent = produkt.opis;

        // Tworzenie przycisku
        const button = document.createElement('button');
        button.textContent = 'Kup teraz';

        // Dodawanie elementów do karty
        card.appendChild(img);
        card.appendChild(h3);
        card.appendChild(p);
        card.appendChild(button);

        // Dodawanie karty do kontenera
        container.appendChild(card);
      });
    })
    .catch(error => {
      // Logowanie błędów
      console.error('Błąd podczas ładowania danych:', error);
    });
