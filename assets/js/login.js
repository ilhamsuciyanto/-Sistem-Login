document.addEventListener("DOMContentLoaded", () => {
    const passwordInput = document.getElementById("password");
    const togglePassword = document.getElementById("togglePassword");

    if (!passwordInput || !togglePassword) return;

    togglePassword.addEventListener("click", () => {
        const isPassword = passwordInput.type === "password";
        
        passwordInput.type = isPassword ? "text" : "password";
        togglePassword.textContent = isPassword ? "🙈" : "👁";
        togglePassword.setAttribute(
            "aria-label", 
            isPassword ? "Sembunyikan password" : "Tampilkan password"
        );
    });
});