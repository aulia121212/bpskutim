
// Pagination interaktif
document.querySelectorAll('.page-btn:not(.nav)').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.page-btn:not(.nav)').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
    });
});

// Topik filter — highlight active
document.querySelectorAll('.topik-card').forEach(card => {
    card.addEventListener('click', function(e) {
        // Sudah pakai href, tidak perlu JS tambahan
    });
});

