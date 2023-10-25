function getAll() {
    fetch('/backend/venda.php', {
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
        displayUsers(data);
    })
    .catch(error => alert('Erro na requisição: ' + error));
}
function displayUsers(data) {
    let legendas = [];
    let valores = [];
    const produtos = data.status;  
    console.log(produtos);
    produtos.forEach(user => {
        legendas.push(user.id);
        valores.push(user.quantidade_produtos);
    });
    //const barColors = ["red", "green","blue","orange","brown"];
                    
        //     new Chart("myChart", {
        //    // type: "bar",
        //     type: "pie",
        //     data: {
        //         labels: legendas,
        //         datasets: [{
        //         backgroundColor: barColors,
        //         data: valores
        //         }]
        //     },
        //     options: {
        //         legend: {display: false},
        //         title: {
        //         display: true,
        //         text: "Usuários e produtos vinculados"
        //         }
        //     }
        //     });
            const barColors = ["red", "green","blue","orange","brown"];
            
            new Chart("myChart", {
              type: "bar",
              data: {
                labels: legendas,
                datasets: [{
                  backgroundColor: barColors,
                  data: valores
                }]
              },
              options: {
            legend: {display: false},
              title: {
              display: true,
              text: "Usuários e produtos vinculados"
              }}
            });
}
getAll();

