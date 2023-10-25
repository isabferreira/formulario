function updateProd() {
    const prodId = document.getElementById("getProdId").value;
    const prodName = document.getElementById("inpuNome").value;
    const prodPreco = document.getElementById("inputPreco").value;
    const prodQuant = document.getElementById("inputQuant").value;
    
    const produtoAtualizado = {
        nome: prodName,
        preco: prodPreco,
        quantidade: prodQuant
    };

    fetch('/backend/produtos.php?id=' + prodId, { 
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(produtoAtualizado)
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
            alert("Não pode atualizar: ");
        }else{
            swal("Produto atualizado!", " ", "success");
        } 
        
    })
    .catch(error => alert('Erro na requisição: ' +error));
}