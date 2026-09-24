/**
 * logout-modal.js
 * Popup konfirmasi sebelum logout.
 */
document.addEventListener("DOMContentLoaded", () => {
    const overlay    = document.getElementById("logoutOverlay");
    const btnLogout  = document.getElementById("btnLogout");
    const btnCancel  = document.getElementById("btnCancelLogout");
    const btnConfirm = document.getElementById("btnConfirmLogout");

    if (!overlay || !btnLogout) return;

    function openModal() {
        overlay.style.display = "flex";
        // Paksa reflow agar transisi opacity berjalan
        requestAnimationFrame(() => {
            overlay.classList.add("active");
        });
    }

    function closeModal() {
        overlay.classList.remove("active");
        // Tunggu animasi selesai baru sembunyikan
        overlay.addEventListener("transitionend", () => {
            overlay.style.display = "none";
        }, { once: true });
    }

    // Buka modal saat klik Logout
    btnLogout.addEventListener("click", (e) => {
        e.preventDefault();
        openModal();
    });

    // Tutup modal saat klik Batal
    btnCancel.addEventListener("click", closeModal);

    // Tutup modal saat klik area gelap di luar modal
    overlay.addEventListener("click", (e) => {
        if (e.target === overlay) closeModal();
    });

    // Tutup modal saat tekan Escape
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && overlay.classList.contains("active")) {
            closeModal();
        }
    });

    // Konfirmasi logout
    btnConfirm.addEventListener("click", () => {
        window.location.href = btnLogout.getAttribute("href");
    });
});
