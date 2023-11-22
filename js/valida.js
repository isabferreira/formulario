    document.addEventListener("DOMContentLoaded", async function() {
    const token = sessionStorage.getItem('token');
    if (!token) {
        redirecioneLogin();
        return;
    }

  async function validaToken() {
    try {
        const response = await fetch('backend/login.php', {
            method: 'GET',
            headers: {
                'Authorization':  token
            }
        });
        const jsonResponse = await response.json();

    if (!jsonResponse.status) {
        window.location.href = 'index.html';
       } 
       console.log(jsonResponse);
    const telasPermitidas = jsonResponse.telas.map(telas => telas.nome);
    const nomePaginaAtual = window.location.pathname.split('/').pop().replace('.html', '');
    const itensMenu = document.querySelectorAll('a.ini');
    itensMenu.forEach(item => {
        const nomeTela = item.href.split('/').pop().replace('.html', ''); 
        if (telasPermitidas.includes(nomeTela)) {
            item.parentElement.style.display = 'flex'; 
            item.style.display = 'flex';
        } else {
            item.parentElement.style.display = 'none'; 
            item.style.display = 'none'; 
        }
    });

    if (!telasPermitidas.includes(nomePaginaAtual)) {
        if (telasPermitidas.length > 0) {
            console.log(telasPermitidas[0] + '.html')
            window.location.href = telasPermitidas[0] + '.html';
        } else {
            alert("Token inválido ou expirado!");
            window.location.href = 'index.html';
        }
    }

    document.body.style.display = 'flex';
    if (!response.ok || !jsonResponse.status) {
        redirecioneLogin(jsonResponse.message);
    }
} catch (error) {
    console.error("Erro ao validar token:", error);
}
}

validaToken();

setInterval(validaToken, 60000);
});

function redirecioneLogin() {
    alert("Token inválido ou expirado!")
    window.location.href = "index.html";
}