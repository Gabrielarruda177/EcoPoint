const local = document.getElementById('input-local');
const localizar = document.getElementById('localizar');
const distance = document.getElementById('filter-distance');
const ongs = document.getElementById('filter-ongs');
const centralizar = document.getElementById('btn-centralizar');


let listaPontos = [];

const mapa = new maplibregl.Map({
    container: 'map-simple',
    style: 'https://tiles.openfreemap.org/styles/positron',
    center: [-46.4758, -23.5236],
    zoom: 14.8,
    interactive: false,
    attributionControl: false,
    pitch: 55,
    bearing:20,
});

mapa.on('style.load', () => {
    const camadas = mapa.getStyle().layers;

    camadas.forEach((camada) => {
        const id = camada.id;

        try {
            if (camada.type === 'symbol' || id.includes('building')) {
                mapa.setLayoutProperty(camada.id, 'visibility', 'none');
            }

            if (camada.type === 'background') {
                mapa.setPaintProperty(id, 'background-color', '#dce8d1');
            }
            if (camada.type === 'fill') {
                mapa.setPaintProperty(id, 'fill-color', '#dce8d1');
            }

            if (camada.type === 'line' && (id.includes('road') || id.includes('highway'))) {
                mapa.setPaintProperty(id, 'line-color', '#ffffff');

                const largura = (id.includes('primary') || id.includes('secondary') || id.includes('trunk') || id.includes('motorway'))
                    ? ['interpolate', ['linear'], ['zoom'], 12, 6, 14, 10]
                    : ['interpolate', ['linear'], ['zoom'], 12, 3, 14, 4];

                mapa.setPaintProperty(id, 'line-width', largura);
            }
        } catch (e) {

        }
    });
});

const elMarcador = document.createElement('div');
elMarcador.className = 'pin-map';

const marcador = new maplibregl.Marker({ element: elMarcador })
    .setLngLat([0   , 0])
    .addTo(mapa);

buscarEndereco('Fatec Itaquera', mapa, marcador, 1); //Mapa simplificado

const map = new maplibregl.Map({
    container: 'map-local',
    style: 'https://tiles.openfreemap.org/styles/positron',
    center: [-46.467948231495434, -23.54503618373375],
    zoom: 15,
}); 

map.on('style.load', () => {
    const camadas = map.getStyle().layers;

    camadas.forEach((camada) => {
            const id = camada.id;

        try {
            if (camada.type === 'background') {
                map.setPaintProperty(id, 'background-color', '#d3d3d3');
            }
            
            if (id.includes('building')) {
                if (camada.type === 'fill') {
                    map.setPaintProperty(id, 'fill-color', '#e0e0da');
                }
            }

            if (id.includes('water')) {
                if (camada.type === 'fill') {
                    map.setPaintProperty(id, 'fill-color', '#b3fcff');
                }
            }

            if (id === 'park' || id === 'landcover_wood') {
                map.setLayoutProperty(id, 'visibility', 'visible');
                map.setPaintProperty(id, 'fill-color', '#a6d1a6');
                map.setPaintProperty(id, 'fill-opacity', 0.6);
            }

            if (camada.type === 'line' && !id.includes('casing')) {
                if (id.includes('primary') || id.includes('trunk') || id.includes('motorway')) {
                    map.setPaintProperty(id, 'line-color', '#ffffff');
                    map.setPaintProperty(id, 'line-width', ['interpolate', ['linear'], ['zoom'], 12, 4, 16, 10]);
                    
                } else if (id.includes('secondary') || id.includes('tertiary') || id.includes('minor') || id.includes('street')) {
                    map.setPaintProperty(id, 'line-color', '#f4f4f4');
                    map.setPaintProperty(id, 'line-width', ['interpolate', ['linear'], ['zoom'], 12, 2, 16, 5]);
                }
            }

            
        } catch (e) {

        }
    });
});

map.addControl(new maplibregl.NavigationControl());

const wrapperMarcador = document.createElement('div');
wrapperMarcador.className = 'main-box-pin';
const loMarcador = document.createElement('div');
loMarcador.className = 'pin-map';

wrapperMarcador.appendChild(loMarcador);

const outroMarcador = new maplibregl.Marker({
    element: wrapperMarcador,
    anchor: 'bottom'
})
    .setLngLat([0, 0])
    .addTo(map);

/* DEFINIR OS MARCADORESSS */

buscarEndereco('Fatec Itaquera', map, outroMarcador, 1);

localizar.addEventListener("click", function() {
    let endereco = local.value
    if(endereco == "") {
        alert('É necessário um endereço!');
    } else {
        buscarEndereco(endereco, map, outroMarcador, 0);
    }
}); //Mapa completo

async function buscarEndereco(endereco, mapas, marcadores, definirMarcador) {
    if (!endereco || endereco.trim().length < 4) {
        alert('Endereço inválido!');
        return
    };

    const params = new URLSearchParams({
        format: 'json',
        q: endereco,
        addressdetails: '1', 
        limit: '5'
    });

    const url = `https://nominatim.openstreetmap.org/search?${params.toString()}`;

    try {
        const resposta = await fetch(url, {
            headers: { 'Accept-Language': 'pt-BR' }
        });
        const dados = await resposta.json();

        if (dados.length > 0) {
            const lon = parseFloat(dados[0].lon);
            const lat = parseFloat(dados[0].lat);

            mapas.setCenter([lon, lat]);
            if(definirMarcador) marcadores.setLngLat([lon, lat]);
            else {

            }
        }
    } catch (erro) {
        console.error('Erro ao consultar o Nominatim:', erro);
    }
}

function calcularDistanciaKm(lat1, lon1, lat2, lon2) {
    const R = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat / 2) ** 2 +
              Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
              Math.sin(dLon / 2) ** 2;
    return R * (2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a)));
}

function aplicarFiltros() {
    listaPontos.forEach(ponto => {
        const dist = calcularDistanciaKm(centroAtual.lat, centroAtual.lng, ponto.lat, ponto.lng);
        
        const dentroDoRaio = (distance === 'all') || (dist <= parseFloat(raioMax));
        const mesmaOng = (ongs === 'all') || (String(ponto.ong_id) === ongId);

        ponto.marker.getElement().style.display = (dentroDoRaio && mesmaOng) ? 'block' : 'none';
    });
} //Funções

distance.addEventListener('change', aplicarFiltros);
ongs.addEventListener('change', aplicarFiltros);

centralizar.addEventListener('click', () => {
    map.flyTo({
        center: [centroAtual.lng, centroAtual.lat],
        zoom: zoomPadrao,
        essential: true
    });
});