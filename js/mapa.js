
function criarMarcadores(mapa) {
    fetch('/backend/endereco.php')
      .then(response => response.json())
      .then(data => {
        console.log('Dados do backend:', data);
        data.endereco.forEach((enderecos) => {
          const marker = L.marker([enderecos.latitude, enderecos.longitude]).addTo(mapa);
          marker.bindPopup(`<b>${enderecos.nome}</b><br>${enderecos.cidade}`);
        });
      })
      .catch(error => console.error('Error loading location data:', error));
  }
  
  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
      alert("Geolocation is not supported by this browser.");
    }
  }
  
  function showPosition(position) {
    let latitude  = position.coords.latitude;
    let longitude = position.coords.longitude;
     //minha localização fake
    let x=-'23.55879';
    let y=-'46.65956';
    const mapa = L.map("mapid").setView([x, y], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 18
    }).addTo(mapa);
  
   
    const eu = L.marker([x, y]).addTo(mapa);
          eu.bindPopup(`<b>Estou</b><br>Aqui`);
          L.circle([x, y], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 1000
          }).addTo(mapa);
    criarMarcadores(mapa);
  }
  
  function showError(error) {
    alert(`Geolocation error: ${error.message}`);
  }
  
  getLocation();
  