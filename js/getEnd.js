document.getElementById('getEndButton').addEventListener('click', getAll);
var token = localStorage.getItem('token');
function getAll() {
    fetch('/backend/endereco.php', {
        method: 'GET',
        headers: {
            'Authorization': token,
        }
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
        displayEnd(data);
    })
    .catch(error => alert('Erro na requisição: ' + error));
}

function displayEnd(data) {
    const enderecos = data.endereco;  
    const enderecoDiv = document.getElementById('endList');
    enderecoDiv.innerHTML = ''; 

    const list = document.createElement('ul');
    enderecos.forEach(enderecos => {
        const listItem = document.createElement('li');
        listItem.textContent = `${enderecos.cep} - ${enderecos.rua} - ${enderecos.cidade} - ${enderecos.latitude} - ${enderecos.longitude}`;
        list.appendChild(listItem);
    });

    enderecoDiv.appendChild(list);
}
getAll();