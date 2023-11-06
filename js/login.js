document.getElementById('loginForm').addEventListener('submit', function(event){
  event.preventDefault();

      const emailUsuario = document.getElementById('email').value;
      const senhaUsuario = document.getElementById('senha').value;
  
      if (!emailUsuario) {
          alert("Por favor, insira um email!");
          return;
      }
  
      const usuario = {
          email: emailUsuario,
          senha: senhaUsuario
      };
  
      fetch('/backend/login.php', { 
          method: 'POST',
          headers: {
              'Content-Type': 'application/json'
          },
          body: JSON.stringify(usuario)
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
              alert('Erro ao logar')
          }else{
              swal("Login feito com sucesso!", " ", "success");
          } 
         
      })
      .catch(error => alert('Erro na requisição: ' + error));
  });