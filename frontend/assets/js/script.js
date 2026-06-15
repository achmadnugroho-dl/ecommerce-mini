// 🔐 VALIDASI LOGIN
function validateLogin() {
    const username = document.querySelector("input[name='username']").value.trim();
    const password = document.querySelector("input[name='password']").value;
    if (!username || !password) {
        alert("Username dan Password wajib diisi!");
        return false;
    }
    return true;
}

// 📝 VALIDASI REGISTER
function validateRegister() {
    const username = document.querySelector("input[name='username']").value.trim();
    const password = document.querySelector("input[name='password']").value;
    if (username.length < 3) {
        alert("Username minimal 3 karakter!");
        return false;
    }
    if (password.length < 5) {
        alert("Password minimal 5 karakter!");
        return false;
    }
    return true;
}
