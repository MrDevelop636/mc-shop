document.addEventListener('DOMContentLoaded', function () {
    // Pobierz elementy
    const modal = document.getElementById('product-modal');
    const closeModal = document.getElementById('close-modal');
    const shopNowButton = document.getElementById('shop-now');
  
    // Otwórz modal po kliknięciu przycisku "Zobacz Produkty"
    shopNowButton.addEventListener('click', function() {
      modal.style.display = 'block';
    });
  
    // Zamknij modal po kliknięciu przycisku zamknięcia
    closeModal.addEventListener('click', function() {
      modal.style.display = 'none';
    });
  
    // Zamknij modal, jeśli klikniesz poza jego obszarem
    window.addEventListener('click', function(event) {
      if (event.target === modal) {
        modal.style.display = 'none';
      }
    });
  });
  