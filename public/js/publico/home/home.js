const local = document.getElementById('input-local');
const localizar = document.getElementById('localizar');
const distance = document.getElementById('filter-distance');
const ongs = document.getElementById('filter-ongs');
const centralizar = document.getElementById('btn-centralizar');

// Estado global do mapa principal
const zoomPadrao = 14;
let centroAtual = {
    lng: -46.467948231495434,
    lat: -23.54503618373375
};

let listaPontos = [];

// ==========================================
// 1. MAPA SIMPLIFICADO (HERO)
// ==========================================
const mapa = new maplibregl.Map({
    container: 'map-simple',
    style: 'https://tiles.openfreemap.org/styles/positron',
    center: [-46.4758, -23.5236],
    zoom: 14.8,
    interactive: false,
    attributionControl: false,
    pitch: 55,
    bearing: 20,
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
        } catch (e) {}
    });
});

const elMarcador = document.createElement('div');
elMarcador.className = 'pin-map';

const marcador = new maplibregl.Marker({ element: elMarcador })
    .setLngLat([-46.4758, -23.5236])
    .addTo(mapa);

buscarEndereco('Fatec Itaquera', mapa, marcador, true);

// ==========================================
// 2. MAPA COMPLETO (LOCALIZE AQUI)
// ==========================================
const map = new maplibregl.Map({
    container: 'map-local',
    style: 'https://tiles.openfreemap.org/styles/positron',
    center: [centroAtual.lng, centroAtual.lat],
    zoom: zoomPadrao,
});

map.on('style.load', () => {
    const camadas = map.getStyle().layers;
    camadas.forEach((camada) => {
        const id = camada.id;
        try {
            if (camada.type === 'background') {
                map.setPaintProperty(id, 'background-color', '#d3d3d3');
            }
            if (id.includes('building') && camada.type === 'fill') {
                map.setPaintProperty(id, 'fill-color', '#e0e0da');
            }
            if (id.includes('water') && camada.type === 'fill') {
                map.setPaintProperty(id, 'fill-color', '#b3fcff');
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
            if (camada.type === 'symbol' && camada.layout && camada.layout['text-field']) {
                map.setLayoutProperty(id, 'text-field', [
                    'coalesce',
                    ['get', 'name:pt'],
                    ['get', 'name']
                ]);
            }
        } 
        catch (e) {
            
        }
    });
});

map.addControl(new maplibregl.NavigationControl());

// Marcador da posição do usuário (Preto/Azul)
const wrapperMarcador = document.createElement('div');
wrapperMarcador.className = 'main-box-pin';
const loMarcador = document.createElement('div');
loMarcador.className = 'pin-map';
wrapperMarcador.appendChild(loMarcador);

const marcadorUsuario = new maplibregl.Marker({
    element: wrapperMarcador,
    anchor: 'bottom'
})
    .setLngLat([centroAtual.lng, centroAtual.lat])
    .addTo(map);

// ==========================================
// 3. SINCRONIZAÇÃO COM O BANCO DE DADOS
// ==========================================
const sleep = (ms) => new Promise(resolve => setTimeout(resolve, ms));

async function carregarPontosDoBanco() {
    const pontos = window.DADOS_BANCO?.pontos || [];

    if (pontos.length === 0) return;

    for (let i = 0; i < pontos.length; i++) {
        const ponto = pontos[i];
        let lat = parseFloat(ponto.latitude);
        let lng = parseFloat(ponto.longitude);

        // Se o ponto ainda não tiver lat/lng no banco, geocodifica pelo endereço
        if (isNaN(lat) || isNaN(lng)) {
            const enderecoCompleto = `${ponto.endereco}, ${ponto.numero || ''} - ${ponto.bairro || ''}, ${ponto.cidade || 'São Paulo'} - ${ponto.estado || 'SP'}`;
            const coords = await geocodificarNominatim(enderecoCompleto);

            if (coords) {
                lat = coords.lat;
                lng = coords.lng;
            }
            // Respeita a política de 1 req/seg do Nominatim para não tomar bloqueio 403
            await sleep(1100);
        }

        if (!isNaN(lat) && !isNaN(lng)) {
            criarMarcadorEcoponto(ponto, lat, lng);
        }
    }

    // Seleciona o primeiro ponto automaticamente para preencher o card lateral (#simple-desc)
    if (listaPontos.length > 0) {
        atualizarPainelLateral(listaPontos[0].dados);
    }
}

function criarMarcadorEcoponto(ponto, lat, lng) {
    const el = document.createElement('div');
    el.className = 'ecoponto-pin';
    el.style.width = '28px';
    el.style.height = '28px';
    el.style.backgroundColor = '#78c83c';
    el.style.border = '4px solid #ffffff';
    el.style.borderRadius = '50%';
    el.style.boxShadow = '0 3px 8px rgba(0,0,0,0.3)';
    el.style.cursor = 'pointer';

    const marker = new maplibregl.Marker({ element: el })
        .setLngLat([lng, lat])
        .addTo(map);

    // Ao clicar no marcador, atualiza o card #simple-desc
    el.addEventListener('click', () => {
        atualizarPainelLateral(ponto);
        map.flyTo({ center: [lng, lat], zoom: 16 });
    });

    listaPontos.push({
        id: ponto.id,
        ong_id: ponto.ong_id,
        lat: lat,
        lng: lng,
        marker: marker,
        dados: ponto
    });
}

function atualizarPainelLateral(ponto) {
    const estadoEl = document.getElementById('estado');
    const fotoOngEl = document.getElementById('foto-ong');
    const nomeEl = document.getElementById('nome-ecoponto');
    const enderecoEl = document.getElementById('endereco-ponto');
    const referenciaEl = document.getElementById('referencia-ponto');
    const horarioEl = document.getElementById('hr-funcionamento-ponto');
    const capacidadeEl = document.getElementById('capacidade-ponto');
    const ongEl = document.getElementById('ong-ponto');
    const btnDetails = document.getElementById('see-details');

    // Status Aberto / Fechado (adapte conforme o nome da coluna no seu PontoDeColeta)
    const estaAberto = ponto.ativo !== false;
    estadoEl.textContent = estaAberto ? '● Aberto agora' : '● Fechado agora';
    estadoEl.style.backgroundColor = estaAberto ? '#E2F3D1' : '#fde8e8';
    estadoEl.style.color = estaAberto ? '#36682B' : '#9b1c1c';

    // Foto (usa a foto do ponto/ONG se houver, senão mantém a logo padrão)
    if (ponto.foto) {
        fotoOngEl.src = `/storage/${ponto.foto}`;
    }

    // Nome do Ecoponto
    nomeEl.textContent = ponto.nome || `Ecoponto ${ponto.ong?.nome || ''}`;

    // Endereço formatado
    const rua = ponto.endereco || '';
    const num = ponto.numero ? `, ${ponto.numero}` : '';
    const bairro = ponto.bairro ? ` - ${ponto.bairro}` : '';
    const cidade = ponto.cidade ? `, ${ponto.cidade}` : '';
    const uf = ponto.estado ? ` - ${ponto.estado}` : '';
    enderecoEl.textContent = `${rua}${num}${bairro}${cidade}${uf}`;

    // Ponto de referência (usa complemento ou ponto_referencia do seu banco)
    referenciaEl.textContent = ponto.ponto_referencia || ponto.complemento || 'Sem ponto de referência informado';

    // Horário de funcionamento
    horarioEl.textContent = ponto.horario_funcionamento || 'Consulte horários com a ONG';

    // Capacidade
    capacidadeEl.innerHTML = `<span class="principal">Capacidade: </span>${ponto.capacidade || 'Não informada'}`;

    // Nome da ONG responsável
    ongEl.textContent = `ONG Responsável: ${ponto.ong?.nome || 'Não informada'}`;

    // Ação do botão "Ver Detalhes Completos"
    btnDetails.onclick = () => {
        window.location.href = `/pontos/${ponto.id}`; 
    };

}

// ==========================================
// 4. GEOCODIFICAÇÃO E BUSCA DE ENDEREÇO
// ==========================================
async function geocodificarNominatim(endereco) {
    if (!endereco || endereco.trim().length < 4) return null;

    const params = new URLSearchParams({
        format: 'json',
        q: endereco,
        addressdetails: '1',
        limit: '1'
    });

    try {
        const resposta = await fetch(`https://nominatim.openstreetmap.org/search?${params.toString()}`, {
            headers: { 'Accept-Language': 'pt-BR' }
        });
        const dados = await resposta.json();

        if (dados.length > 0) {
            return {
                lat: parseFloat(dados[0].lat),
                lng: parseFloat(dados[0].lon)
            };
        }
    } catch (erro) {
        console.error('Erro ao consultar o Nominatim:', erro);
    }
    return null;
}

async function buscarEndereco(endereco, mapaAlvo, marcadorAlvo, atualizarCentroGlobal = false) {
    if (!endereco || endereco.trim().length < 4) {
        alert('Endereço inválido!');
        return;
    }

    const coords = await geocodificarNominatim(endereco);
    if (coords) {
        mapaAlvo.flyTo({ center: [coords.lng, coords.lat], zoom: 15 });
        marcadorAlvo.setLngLat([coords.lng, coords.lat]);

        if (atualizarCentroGlobal) {
            centroAtual = { lat: coords.lat, lng: coords.lng };
            aplicarFiltros();
        }
    } else {
        alert('Endereço não encontrado.');
    }
}

localizar.addEventListener('click', () => {
    const endereco = local.value;
    if (!endereco.trim()) {
        alert('É necessário um endereço!');
    } else {
        buscarEndereco(endereco, map, marcadorUsuario, true);
    }
});

// Permite buscar apertando Enter no input
local.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        e.preventDefault();
        localizar.click();
    }
});

// ==========================================
// 5. FILTROS DE DISTÂNCIA E ONG
// ==========================================
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
    const raioMax = distance.value; // 'all', '2', '5', '10', '25'
    const ongId = ongs.value;       // 'all' ou ID da ONG

    listaPontos.forEach(ponto => {
        const dist = calcularDistanciaKm(centroAtual.lat, centroAtual.lng, ponto.lat, ponto.lng);

        const dentroDoRaio = (raioMax === 'all') || (dist <= parseFloat(raioMax));
        const mesmaOng = (ongId === 'all') || (String(ponto.ong_id) === String(ongId));

        ponto.marker.getElement().style.display = (dentroDoRaio && mesmaOng) ? 'block' : 'none';
    });
}

distance.addEventListener('change', aplicarFiltros);
ongs.addEventListener('change', aplicarFiltros);

centralizar.addEventListener('click', () => {
    map.flyTo({
        center: [centroAtual.lng, centroAtual.lat],
        zoom: zoomPadrao,
        essential: true
    });
});

// Inicia o carregamento dos marcadores do MySQL
carregarPontosDoBanco();
