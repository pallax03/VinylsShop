// flip cards
document.querySelectorAll('.btn-specular').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        const flipContainer = this.closest('.flip');

        if (flipContainer) {
            const cards = flipContainer.querySelectorAll('.card');
            
            cards.forEach(card => {
                if (!card.classList.contains('active')) {
                    card.classList.add('active');
                } else {
                    card.classList.remove('active');
                }
            });
        }
    });
});

