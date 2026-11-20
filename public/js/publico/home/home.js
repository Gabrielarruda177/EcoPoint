const local = document.getElementById('input-local');
const btn = document.getElementById('btn');

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
        try {
            if (camada.type === 'symbol' || camada.id.includes('building')) {
                mapa.setLayoutProperty(camada.id, 'visibility', 'none');
            }

            if (camada.type === 'background') {
                mapa.setPaintProperty(camada.id, 'background-color', '#dce8d1');
            }
            if (camada.type === 'fill') {
                mapa.setPaintProperty(camada.id, 'fill-color', '#dce8d1');
            }

            if (camada.type === 'line' && (camada.id.includes('road') || camada.id.includes('highway'))) {
                mapa.setPaintProperty(camada.id, 'line-color', '#ffffff');

                const largura = (camada.id.includes('primary') || camada.id.includes('secondary') || camada.id.includes('trunk') || camada.id.includes('motorway'))
                    ? ['interpolate', ['linear'], ['zoom'], 12, 6, 14, 10]
                    : ['interpolate', ['linear'], ['zoom'], 12, 3, 14, 4];

                mapa.setPaintProperty(camada.id, 'line-width', largura);
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

buscarEndereco('Fatec Itaquera', mapa, marcador); //Mapa simplificado

const map = new maplibregl.Map({
    container: 'map-local',
    style: 'https://tiles.openfreemap.org/styles/positron',
    center: [-46.467948231495434, -23.54503618373375],
    zoom: 15,
}); 

map.on('style.load', () => {
    const camadas = map.getStyle().layers;

    camadas.forEach((camada) => {
        try {
            if (camada.type === 'background') {
                map.setPaintProperty(camada.id, 'background-color', '#f0f8eb');
            }
            if (camada.type === 'fill') {
                map.setPaintProperty(camada.id, 'fill-color', '#d8dbe8');
            }

            const ehAvenida = camada.id.includes('primary') || camada.id.includes('secondary') || camada.id.includes('trunk') || camada.id.includes('motorway');

            if (camada.id.includes('casing') || camada.id.includes('outline')) {
                mapa.setLayoutProperty(camada.id, 'visibility', 'visible');
                mapa.setPaintProperty(camada.id, 'line-color', '#b3c9a2');

                const larguraBorda = ehAvenida
                    ? ['interpolate', ['linear'], ['zoom'], 12, 6, 16, 14]
                    : ['interpolate', ['linear'], ['zoom'], 12, 3.5, 16, 6];

                map.setPaintProperty(camada.id, 'line-width', larguraBorda);
            } else {
                map.setPaintProperty(camada.id, 'line-color', '#fff');

                const larguraMiolo = ehAvenida
                    ? ['interpolate', ['linear'], ['zoom'], 12, 4, 16, 10]
                    : ['interpolate', ['linear'], ['zoom'], 12, 2, 16, 5];

                map.setPaintProperty(camada.id, 'line-width', larguraMiolo);
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

buscarEndereco('Fatec Itaquera', map, outroMarcador);

btn.addEventListener("click", function() {
    let endereco = local.value
    if(endereco == "") {
        alert('É necessário um endereço!');
    } else {
        buscarEndereco(endereco, map, outroMarcador);
    }
});

async function buscarEndereco(endereco, mapas, marcadores) {
    if (!endereco) return;
    
    const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(endereco)}&limit=1`;

    try {
        const resposta = await fetch(url, {
            headers: { 'Accept-Language': 'pt-BR' }
        });
        const dados = await resposta.json();

        if (dados.length > 0) {
            const lon = parseFloat(dados[0].lon);
            const lat = parseFloat(dados[0].lat);

            mapas.setCenter([lon, lat]);
            marcadores.setLngLat([lon, lat]);
        }
    } catch (erro) {
        console.error('Erro ao consultar o Nominatim:', erro);
    }
}
//Mapa completo