function deletarProd() {
    const prodId = document.getElementById("getProdId").value;
    fetch('/backend/produtos.php?id=' + prodId, {
        method: 'DELETE'
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
            alert("Não pode Deletar: ");
        }else{
            swal("Produto deletado!", " ", "success");
            document.getElementById("inpuNome").value = ''; 
            document.getElementById("inputPreco").value = ''; 
            document.getElementById("inputQuant").value = ''; 
        } 
    }) 
    .catch(error => alert('Erro na requisição: ' + error));
}