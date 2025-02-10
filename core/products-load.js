document.addEventListener("DOMContentLoaded", function () {
  fetch("./core/db/products.json") // Zamień na rzeczywistą ścieżkę do pliku JSON
      .then(response => response.json())
      .then(data => {
          const container = document.querySelector(".product-container"); // Kontener na wszystkie produkty
          
          if (container && Array.isArray(data)) {
              container.innerHTML = ""; // Wyczyść kontener przed dodaniem nowych elementów
              
              data.forEach(product => {
                  const productCard = document.createElement("div");
                  productCard.classList.add("product-card");
                  
                  productCard.innerHTML = `
                      <img src="${product.img}" alt="${product.title}">
                      <h3>${product.title}</h3>
                      <p>${product.description}</p>
                      <button>Kup teraz</button>
                  `;
                  
                  container.appendChild(productCard);
              });
          }
      })
      .catch(error => console.error("Błąd wczytywania danych:", error));
});
