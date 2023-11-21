async function deleteEnd(idendereco){
    fetch('/backend/endereco.php?id=' + idendereco, {
        method: 'POST', 
        headers: {
            "Content-Type": "application/json"
        },
        body:JSON.stringify({acao:"Deletar"})
    });
     return await resposta.json();
}
function getUser(){
    const userId = document.getElementById("getUserId").value;
    
    fetch('/backend/usuarios.php?id=' + userId, {
        method: 'GET'
    })
    .then(response => {
        if (!response.ok) {
            if (response.status === 401) {
                throw new Error('Não autorizado');
            } else {
                throw new Error('Sem rede ou não conseguiu localizar o recurso');
            }
        }
        return response.json();
    })
    .then(data => {
        if(!data.status){
            alert('Usuário não encontrado');
            document.getElementById("inpuNome").value = '';
        }else{
            console.log(data);
            document.getElementById("inpuNome").value = data.usuario.nome; 
            document.getElementById("inputEmail").value = data.usuario.email;
            const listEnd = document.getElementById("listEnd");
            const ul =  document.createElement("ul");
            ul.setAttribute("id", "listEnd");
            const enderecos = data.enderecos;
            enderecos.forEach(enderecos =>{
                const li = document.createElement("li");
                li.textContent = `${enderecos.id} - ${enderecos.cep}`;
                const button = document.createElement("button");
                button.setAttribute("id", "submitButtonUsuario");
                button.style.marginTop = "12px";
                button.textContent = "Excluir";
                button.addEventListener("click", function(){
                    const result = deleteEnd(enderecos.id);
                    alert("O endereço foi removido!!");
                    li.remove(); 
                });
                li.appendChild(button);
                ul.appendChild(li);
            });
            listEnd.appendChild(ul);
        } 
    })
    .catch(error => alert('Erro na requisição: ' + error));
}