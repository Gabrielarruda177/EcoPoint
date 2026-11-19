const mapa = new maplibregl.Map({
    container: 'map',
    style: 'https://tiles.openfreemap.org/styles/positron',
    center: [-46.4758, -23.5236], // [longitude, latitude]
    zoom: 14.5,
    interactive: false, // Trava arraste e zoom
    attributionControl: false,
    pitch: 45,
    bearing:-20,
});

mapa.on('style.load', () => {
    const camadas = mapa.getStyle().layers;

    camadas.forEach((camada) => {
        if (camada.type === 'symbol' || camada.id.includes('building')) {
            mapa.setLayoutProperty(camada.id, 'visibility', 'none');
        }

        if (camada.type === 'background') {
            mapa.setPaintProperty(camada.id, 'background-color', '#D4EEAD');
        }
        if (camada.type === 'fill') {
            mapa.setPaintProperty(camada.id, 'fill-color', '#D4EEAD');
        }

        if (camada.type === 'line' && (camada.id.includes('road') || camada.id.includes('highway'))) {
            mapa.setPaintProperty(camada.id, 'line-color', '#ffffff');
            mapa.setPaintProperty(camada.id, 'line-width', 3.5);
        }
    });
});

const elMarcador = document.createElement('div');
elMarcador.className = 'marker-ring';

const marcador = new maplibregl.Marker({ element: elMarcador })
    .setLngLat([-46.40019698406312, -23.573919505354258])
    .addTo(mapa);

async function buscarEndereco(endereco) {
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

            mapa.setCenter([lon, lat]);
            marcador.setLngLat([lon, lat]);
        }
    } catch (erro) {
        console.error('Erro ao consultar o Nominatim:', erro);
    }
}

buscarEndereco('R. Igarapé Palmeira, 26 - São Paulo');