document.getElementById('getAllButton').addEventListener('click', getAllProd);
function getAllProd() {
    fetch('/backend/produtos.php', {
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
        displayProd(data);
    })
    .catch(error => alert('Erro na requisição: ' + error));
}

function displayProd(data) {
    const produtos = data.produto;  
    const produtosDiv = document.getElementById('prodList');
    produtosDiv.innerHTML = ''; 

    const list = document.createElement('ul');
    produtos.forEach(produto => {
        const listItem = document.createElement('li');
        listItem.textContent = `${produto.id} - ${produto.nome} - ${produto.preco} - ${produto.quantidade}`;
        list.appendChild(listItem);
    });

    produtosDiv.appendChild(list);
}
getAllProd();