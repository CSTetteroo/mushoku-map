<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mushoku Tensei World Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        html, body, #map { height: 100%; margin: 0; }
        .leaflet-control button { font-family: sans-serif; }
        .toolbar {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1000;
            background: rgba(255,255,255,0.9);
            padding: 8px;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
        }
        .toolbar h4 { margin: 0 0 6px; font-size: 14px; }
        .toolbar button { margin: 2px 0; width: 100%; }
        .help-tip { font-size: 12px; margin-top: 6px; color: #333; }
        .color-dot { display:inline-block; width:10px; height:10px; border-radius:50%; vertical-align:middle; margin-right:6px; border:1px solid #aaa; }
        .place-number {
            background: #222; color: #fff; border-radius: 10px; padding: 0 6px; font-weight: 700;
            border: 1px solid #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.4);
        }
        .road-badges {
            pointer-events: none;
            /* background: rgba(255,255,255,0.9); */
            border-radius: 12px;
            padding: 2px 6px;
            /* border: 1px solid rgba(0,0,0,0.2);
            box-shadow: 0 1px 3px rgba(0,0,0,0.25); */
            font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
            /* center the badge exactly on the coordinate */
            transform: translate(-50%, -50%);
        }
        .road-badges .badge {
            display: inline-block;
            min-width: 18px; height: 18px; line-height: 18px;
            margin: 0 2px; padding: 0 4px;
            border-radius: 9px; background: #222; color: #fff; font-size: 12px; font-weight: 700;
            text-align: center; border: 1px solid #fff;
        }
        /* Generic badge styling for panel usage */
        .badge {
            display: inline-block;
            min-width: 18px; height: 18px; line-height: 18px;
            margin: 0 4px 4px 0; padding: 0 6px;
            border-radius: 9px; background: #222; color: #fff; font-size: 12px; font-weight: 700;
            text-align: center; border: 1px solid #fff;
        }

        /* Futuristic sliding side panel */
        .side-panel {
            position: fixed;
            top: 0;
            right: 0;
            height: 100%;
            width: 420px;
            max-width: 90vw;
            transform: translateX(100%);
            transition: transform 260ms ease-out, box-shadow 260ms ease-out;
            z-index: 2000;
            display: flex;
            flex-direction: column;
            background: linear-gradient(180deg, rgba(10,10,14,0.92) 0%, rgba(17,22,26,0.94) 100%);
            backdrop-filter: blur(10px);
            color: #e6f0ff;
            border-left: 1px solid rgba(0,255,200,0.25);
            box-shadow: -10px 0 30px rgba(0,0,0,0.35);
        }
        .side-panel.open { transform: translateX(0); }
        .side-panel-header {
            padding: 14px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(0,255,200,0.2);
            background: linear-gradient(90deg, rgba(0,200,255,0.12), rgba(0,255,200,0.06) 60%, transparent);
            box-shadow: inset 0 -1px 0 rgba(255,255,255,0.04);
        }
        .side-panel-title {
            font-weight: 700; letter-spacing: 0.3px;
            text-shadow: 0 0 10px rgba(0,255,200,0.35);
        }
        .side-panel-close {
            background: transparent; border: 1px solid rgba(0,255,200,0.35);
            color: #aef; padding: 6px 10px; border-radius: 8px; cursor: pointer;
        }
        .side-panel-close:hover { background: rgba(0,255,200,0.08); }
        .side-panel-content {
            padding: 14px 16px; overflow-y: auto; flex: 1;
        }
        .panel-section { margin-bottom: 14px; }
        .panel-section h5 {
            margin: 0 0 8px; font-size: 13px; font-weight: 700; color: #9fe;
            text-transform: uppercase; letter-spacing: 0.8px;
        }
        .panel-actions button {
            margin: 4px 6px 0 0; padding: 6px 10px;
            border-radius: 8px; border: 1px solid rgba(0,255,200,0.35);
            background: rgba(0,0,0,0.2); color: #e6f0ff; cursor: pointer;
        }
        .panel-actions button:hover { background: rgba(0,255,200,0.08); }
        .visit-item { padding: 6px 8px; border-radius: 8px; background: rgba(255,255,255,0.04); margin: 6px 0; }
        /* Make visit action buttons styled too */
        .visit-item button { margin: 4px 6px 0 0; padding: 6px 10px; border-radius: 8px; border: 1px solid rgba(0,255,200,0.35); background: rgba(0,0,0,0.2); color: #e6f0ff; cursor: pointer; }
        .visit-item button:hover { background: rgba(0,255,200,0.08); }
        .btn-danger { border-color: rgba(255,60,60,0.35) !important; color: #ffb3b3 !important; }
        .btn-danger:hover { background: rgba(255,60,60,0.12) !important; }
        .mono { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace; }

        /* Backdrop */
        .side-panel-backdrop {
            position: fixed; inset: 0; background: rgba(0,0,0,0.25);
            backdrop-filter: blur(2px); z-index: 1500; opacity: 0; pointer-events: none; transition: opacity 200ms ease-out;
        }
        .side-panel-backdrop.open { opacity: 1; pointer-events: auto; }
    </style>
</head>
<body>
    <div id="map"></div>
    <div class="toolbar card">
        <h4>Map tools</h4>
        <button id="btnAddPlace" class="btn btn-primary">➕ Add Place</button>
    <button id="btnStartTravel"class="btn">🧭 Start Travel</button>
    <button id="btnFinish" class="btn" style="display:none;">✅ Finish</button>
    <button id="btnCancel" class="btn" style="display:none;">✖ Cancel</button>
        <div class="help-tip" class="btn" id="helpTip">Click a marker to view visits or add one.</div>
    </div>

    <!-- Sliding side panel -->
    <div id="sidePanel" class="side-panel" aria-hidden="true" role="dialog" aria-modal="true">
        <div class="side-panel-header">
            <div id="sidePanelTitle" class="side-panel-title">Details</div>
            <button id="sidePanelClose" class="side-panel-close" title="Close">✖</button>
        </div>
        <div id="sidePanelContent" class="side-panel-content"></div>
    </div>
    <div id="sidePanelBackdrop" class="side-panel-backdrop"></div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // --- Map setup ---
        const width = 2882;
        const height = 2048;
        const bounds = [[0, 0], [height, width]];
        const map = L.map('map', { crs: L.CRS.Simple, minZoom: -1, maxZoom: 5, doubleClickZoom: false });
        L.imageOverlay('/images/highresmapclearonteal.png', bounds).addTo(map);
        map.fitBounds(bounds);

        // --- State & layers ---
    let places = [];
    let travels = [];
    let visits = [];
        const markersLayer = L.layerGroup().addTo(map);
        const travelsLayer = L.layerGroup().addTo(map);
        let mode = 'view'; // 'view' | 'addPlace' | 'drawTravel'
    let drawState = { startPlace: null, endPlace: null, points: [], tempLine: null };
    let finishHook = null; // optional override for Finish action (e.g., redraw)

        // --- DOM helpers ---
        const btnAddPlace = document.getElementById('btnAddPlace');
        const btnStartTravel = document.getElementById('btnStartTravel');
    const btnFinish = document.getElementById('btnFinish');
    const btnCancel = document.getElementById('btnCancel');
        const helpTip = document.getElementById('helpTip');

        function setMode(newMode) {
            mode = newMode;
            if (mode === 'addPlace') {
                helpTip.textContent = 'Add Place: click anywhere on the map to create a place.';
                btnFinish.style.display = 'none';
                btnCancel.style.display = '';
            } else if (mode === 'drawTravel') {
                helpTip.textContent = drawState.startPlace ? 'Drawing: click to add points; click destination place or press Finish to save.' : 'Start Travel: click a starting place marker.';
                btnFinish.style.display = drawState.startPlace ? '' : 'none';
                btnCancel.style.display = '';
            } else {
                helpTip.textContent = 'Click a marker to view or edit. Use tools to add places or travels.';
                btnFinish.style.display = 'none';
                btnCancel.style.display = 'none';
                cleanupDrawing();
                finishHook = null;
            }
        }

        function cleanupDrawing() {
            if (drawState.tempLine) {
                travelsLayer.removeLayer(drawState.tempLine);
            }
            drawState = { startPlace: null, endPlace: null, points: [], tempLine: null };
        }

        // --- API helpers ---
        const api = {
            get: (url) => fetch(url).then(r => r.json()),
            post: (url, data) => fetch(url, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data) }).then(r => r.json()),
            put: (url, data) => fetch(url, { method: 'PUT', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data) }).then(r => r.json()),
            del: (url) => fetch(url, { method: 'DELETE' })
        };

        // --- Load & render ---
        async function reloadData() {
            [places, travels, visits] = await Promise.all([
                api.get('/api/places'),
                api.get('/api/travels'),
                api.get('/api/place-visits'), // ordered by travel_number (controller)
            ]);
            renderAll();
        }

        function renderAll() {
            markersLayer.clearLayers();
            travelsLayer.clearLayers();

            const placeLabels = computePlaceLabels();
            const visitsByTravel = computeVisitsByTravel();

            // Render travels grouped by exact path match so identical geometries merge (show combined numbers)
            const travelGroups = groupTravelsByPath(travels);
            travelGroups.forEach(group => {
                const rep = group.travels[0];
                const line = L.polyline(rep.path, { color: rep.color || 'red', weight: 3 }).addTo(travelsLayer);
                line.group = group; // attach
                // Wire click to open side panel for this group
                line.on('click', () => openTravelGroupPanel(group, visitsByTravel));

                // Add aggregated travel number badges on the road if any of these travels have visits
                const numbers = [];
                group.travels.forEach(t => {
                    const nums = visitsByTravel[t.id] || [];
                    nums.forEach(n => { if (!numbers.includes(n)) numbers.push(n); });
                });
                numbers.sort((a,b) => a-b);
                if (numbers.length) {
                    const mid = getPathMidpoint(rep.path);
                    const pos = mid;
                    const html = `<div class="road-badges">${numbers.map(n => `<span class=\"badge\">${n}</span>`).join('')}</div>`;
                    const icon = L.divIcon({ className: 'road-badges', html, iconSize: null });
                    L.marker(pos, { icon, interactive: false, keyboard: false }).addTo(travelsLayer);
                }
            });

            // Render places
            places.forEach(p => {
                const m = L.marker([p.y, p.x]).addTo(markersLayer);
                m.place = p;
                // Number label(s) (permanent tooltip) if exist
                if (placeLabels[p.id] && placeLabels[p.id].length) {
                    const text = placeLabels[p.id].join(', ');
                    m.bindTooltip(text, { permanent: true, direction: 'top', className: 'place-number', offset: [0, -16] }).openTooltip();
                }


                m.on('click', async () => {
                    if (mode === 'drawTravel' && !drawState.startPlace) {
                        // Choose start place
                        drawState.startPlace = p;
                        const start = [p.y, p.x];
                        drawState.points = [start];
                        drawState.tempLine = L.polyline(drawState.points, { color: '#555', dashArray: '4,4', weight: 3 }).addTo(travelsLayer);
                        setMode('drawTravel');
                        return;
                    }
                    if (mode === 'drawTravel' && drawState.startPlace) {
                        // If clicked another place, snap as end and finish
                        drawState.points.push([p.y, p.x]);
                        drawState.endPlace = p;
                        await finishTravelDialog();
                        return;
                    }
                    const pv = await api.get(`/api/places/${p.id}/visits`);
                    openPlacePanel(p, pv);
                });
            });
        }

        function computePlaceLabels() {
            // Map place_id => [labels]; start place gets 1; each visit n gives destination label n+1; keep all occurrences
            const labels = {};
            if (!Array.isArray(visits) || visits.length === 0) return labels;
            const ordered = visits.filter(v => v.travel_number != null).slice().sort((a,b) => a.travel_number - b.travel_number);
            if (ordered.length === 0) return labels;
            const first = ordered[0];
            if (first.travel && first.travel.from_place_id) {
                const pid = first.travel.from_place_id;
                labels[pid] = labels[pid] || [];
                if (!labels[pid].includes(1)) labels[pid].push(1);
            }
            ordered.forEach(v => {
                const label = Number(v.travel_number) + 1;
                labels[v.place_id] = labels[v.place_id] || [];
                if (!labels[v.place_id].includes(label)) labels[v.place_id].push(label);
            });
            // Sort each label list ascending
            Object.keys(labels).forEach(pid => labels[pid].sort((a,b) => a-b));
            return labels;
        }

        function computeVisitsByTravel() {
            // Map travel_id => sorted unique list of travel_number(s)
            const map = {};
            if (!Array.isArray(visits)) return map;
            visits.forEach(v => {
                if (!v.travel || v.travel_number == null) return;
                const id = v.travel.id;
                map[id] = map[id] || new Set();
                map[id].add(Number(v.travel_number));
            });
            const out = {};
            Object.keys(map).forEach(id => {
                out[id] = Array.from(map[id]).sort((a,b) => a-b);
            });
            return out;
        }

        function groupTravelsByPath(travels) {
            // Exact-match grouping with reverse detection: A..B equals B..A when points match exactly
            const groups = {};
            travels.forEach(t => {
                try {
                    const key = JSON.stringify(t.path);
                    const revKey = JSON.stringify([...(t.path || [])].reverse());
                    if (groups[key]) {
                        groups[key].travels.push(t);
                    } else if (groups[revKey]) {
                        groups[revKey].travels.push(t);
                    } else {
                        groups[key] = { key, travels: [t] };
                    }
                } catch (e) {
                    // skip non-serializable
                }
            });
            return Object.values(groups);
        }

        function getPathMidpoint(path) {
            if (!Array.isArray(path) || path.length === 0) return [0,0];
            if (path.length === 1) return [path[0][0], path[0][1]];
            // total length
            let total = 0;
            for (let i = 1; i < path.length; i++) {
                const y0 = path[i-1][0], x0 = path[i-1][1];
                const y1 = path[i][0], x1 = path[i][1];
                const dy = y1 - y0, dx = x1 - x0;
                total += Math.hypot(dy, dx);
            }
            const half = total / 2;
            let acc = 0;
            for (let i = 1; i < path.length; i++) {
                const y0 = path[i-1][0], x0 = path[i-1][1];
                const y1 = path[i][0], x1 = path[i][1];
                const seg = Math.hypot(y1 - y0, x1 - x0);
                if (acc + seg >= half) {
                    const remain = half - acc;
                    const t = seg === 0 ? 0 : (remain / seg);
                    return [ y0 + (y1 - y0) * t, x0 + (x1 - x0) * t ];
                }
                acc += seg;
            }
            // fallback: last point
            const last = path[path.length - 1];
            return [last[0], last[1]];
        }

        function resolveBadgePosition([lat, lng], occupied) {
            // Avoid overlapping badge markers by offsetting if another badge is nearby
            const offsets = [
                [0, 0], [0, -18], [0, 18], [-18, 0], [18, 0],
                [-14, -14], [-14, 14], [14, -14], [14, 14],
                [0, -32], [0, 32], [-32, 0], [32, 0]
            ];
            const thresholdSq = 20 * 20; // pixels^2 (Simple CRS -> lat/lng are pixels)
            for (let i = 0; i < offsets.length; i++) {
                const p = [lat + offsets[i][0], lng + offsets[i][1]];
                let ok = true;
                for (const q of occupied) {
                    const dx = p[0] - q[0];
                    const dy = p[1] - q[1];
                    if ((dx*dx + dy*dy) < thresholdSq) { ok = false; break; }
                }
                if (ok) return p;
            }
            // Fallback: slight shift
            return [lat + 40, lng];
        }

        // --- Toolbar wiring ---
        btnAddPlace.addEventListener('click', () => setMode(mode === 'addPlace' ? 'view' : 'addPlace'));
        btnStartTravel.addEventListener('click', () => {
            cleanupDrawing();
            setMode(mode === 'drawTravel' ? 'view' : 'drawTravel');
        });
        btnFinish.addEventListener('click', async () => {
            if (mode !== 'drawTravel') return;
            if (typeof finishHook === 'function') {
                await finishHook();
                return;
            }
            if (!drawState.startPlace) { alert('Select a starting place first.'); return; }
            await finishTravelDialog();
        });
        btnCancel.addEventListener('click', () => setMode('view'));

        // --- Map clicks for modes ---
        map.on('click', async (e) => {
            if (mode === 'addPlace') {
                const name = prompt('Place name?');
                if (!name) return;
                const description = prompt('Description?') || null;
                const { lat, lng } = e.latlng; // Simple CRS: lat=y, lng=x
                await api.post('/api/places', { name, description, x: lng, y: lat });
                setMode('view');
                await reloadData();
            } else if (mode === 'drawTravel' && drawState.startPlace) {
                // Add point to path
                const { lat, lng } = e.latlng;
                drawState.points.push([lat, lng]);
                if (drawState.tempLine) drawState.tempLine.setLatLngs(drawState.points);
            }
        });

        // --- Panel wiring ---
        const sidePanel = document.getElementById('sidePanel');
        const sidePanelTitle = document.getElementById('sidePanelTitle');
        const sidePanelContent = document.getElementById('sidePanelContent');
        const sidePanelClose = document.getElementById('sidePanelClose');
        const sidePanelBackdrop = document.getElementById('sidePanelBackdrop');

        function openPanel(title, html) {
            sidePanelTitle.textContent = title || 'Details';
            sidePanelContent.innerHTML = html || '';
            sidePanel.classList.add('open');
            sidePanelBackdrop.classList.add('open');
            sidePanel.setAttribute('aria-hidden', 'false');
        }
        function closePanel() {
            sidePanel.classList.remove('open');
            sidePanelBackdrop.classList.remove('open');
            sidePanel.setAttribute('aria-hidden', 'true');
        }
        sidePanelClose.addEventListener('click', closePanel);
        sidePanelBackdrop.addEventListener('click', closePanel);
        window.addEventListener('keydown', (e) => { if (e.key === 'Escape') closePanel(); });

        // --- Minimal rich text rendering (bullets + line breaks) ---
        function escapeHtml(s) {
            return (s || '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;');
        }
        function formatRichText(text) {
            if (!text) return '';
            const lines = String(text).replace(/\r\n?/g, '\n').split('\n');
            let html = '';
            let inList = false;
            let inPara = false;
            for (let raw of lines) {
                const line = raw;
                const m = /^\s*-\s+(.*)$/.exec(line);
                if (m) {
                    if (inPara) { html += '</p>'; inPara = false; }
                    if (!inList) { html += '<ul>'; inList = true; }
                    html += `<li>${escapeHtml(m[1])}</li>`;
                    continue;
                }
                if (line.trim() === '') {
                    if (inPara) { html += '</p>'; inPara = false; }
                    if (inList) { html += '</ul>'; inList = false; }
                    continue;
                }
                if (inList) { html += '</ul>'; inList = false; }
                if (!inPara) { html += '<p>'; inPara = true; }
                else { html += '<br>'; }
                html += escapeHtml(line);
            }
            if (inPara) html += '</p>';
            if (inList) html += '</ul>';
            return html;
        }

        function openPlacePanel(place, placeVisits) {
            const visitsHtml = (placeVisits && placeVisits.length)
                ? placeVisits.map(v => (
                    `<div class="visit-item">`
                    + `<b>#${v.travel_number || '-'}</b> <span class="rt">${formatRichText(v.reason || '')}</span> `
                    + (v.story_time ? `<span class="mono">(${v.story_time})</span>` : '')
                    + `<div class=\"panel-actions\" style=\"margin-top:6px\">`
                    + `<button onclick=\"openVisitEdit(${v.id})\">✏️ Edit</button>`
                    + `<button class=\"btn-danger\" onclick=\"deleteVisit(${v.id}, ${place.id})\">🗑 Delete</button>`
                    + `</div>`
                    + `</div>`
                )).join('')
                : '<div class="mono" style="opacity:0.8">No visits yet.</div>';

            const html = `
                <div class="panel-section">
                    <h5>Place</h5>
                    <div><b>${place.name}</b></div>
                    <div class="rt" style="opacity:.9">${formatRichText(place.description || '')}</div>
                </div>
                <div class="panel-section">
                    <h5>Visits</h5>
                    ${visitsHtml}
                </div>
                <div class="panel-section panel-actions">
                    <button onclick="addVisit(${place.id})">➕ Add Visit</button>
                    <button onclick="editPlace(${place.id})">✏️ Edit Place</button>
                    <button onclick="deletePlace(${place.id})">🗑️ Delete Place</button>
                    <button onclick="startTravelFrom(${place.id})">🧭 Start Travel here</button>
                </div>
            `;
            openPanel('Place details', html);
        }

        function openTravelGroupPanel(group, visitsByTravel) {
            const items = group.travels.map(t => {
                const nums = visitsByTravel[t.id] || [];
                const segs = nums.slice().sort((a,b)=>a-b).map(n => `${Number(n)} → ${Number(n)+1}`);
                const numsLine = segs.length ? `<div class=\"mono\">${segs.map(s => `<span class=\"badge\">${s}</span>`).join(' ')}</div>` : '';
                return `
                    <div class=\"visit-item\" style=\"margin-bottom:8px\">
                        <div><span class=\"color-dot\" style=\"background:${t.color || 'red'}\"></span><b>${t.name || t.type || ('Travel #' + t.id)}</b></div>
                        ${t.type ? (`<div>Type: ${t.type}</div>`) : ''}
                        ${t.reason ? (`<div class=\"rt\">${formatRichText(t.reason)}</div>`) : ''}
                        ${numsLine}
                        <div class=\"panel-actions\" style=\"margin-top:6px\">
                            <button onclick=\"editTravel(${t.id})\">✏️ Edit</button>
                            <button onclick=\"redrawTravel(${t.id})\">🖊️ Redraw</button>
                            <button onclick=\"deleteTravel(${t.id})\">🗑️ Delete</button>
                        </div>
                    </div>`;
            }).join('');

            const allNums = [];
            group.travels.forEach(t => {
                (visitsByTravel[t.id] || []).forEach(n => { if (!allNums.includes(n)) allNums.push(n); });
            });
            allNums.sort((a,b) => a-b);
            const segments = allNums.map(n => `${Number(n)} → ${Number(n)+1}`);
            const badges = segments.length ? `<div class=\"panel-section\"><h5>Segments</h5><div>${segments.map(s => `<span class=\"badge\">${s}</span>`).join(' ')}</div></div>` : '';

            const html = `
                ${badges}
                <div class=\"panel-section\"><h5>Travels on this path</h5>${items}</div>
            `;
            openPanel('Travel path', html);
        }

        function openPlaceEditPanel(place) {
            const html = `
                <div class="panel-section">
                    <h5>Edit place</h5>
                    <label>Name<br><input id="pl_name" type="text" value="${(place.name || '').replaceAll('"','&quot;')}" style="width:100%"></label>
                </div>
                <div class="panel-section">
                    <label>Description<br><textarea id="pl_desc" rows="3" style="width:100%">${(place.description || '').replaceAll('<','&lt;')}</textarea></label>
                </div>
                <div class="panel-section" style="display:flex; gap:8px">
                    <label style="flex:1">X (pixel)<br><input id="pl_x" type="number" step="0.1" value="${Number(place.x).toFixed(1)}" style="width:100%"></label>
                    <label style="flex:1">Y (pixel)<br><input id="pl_y" type="number" step="0.1" value="${Number(place.y).toFixed(1)}" style="width:100%"></label>
                </div>
                <div class="panel-actions">
                    <button id="pl_save">💾 Save</button>
                    <button id="pl_cancel">Cancel</button>
                </div>
            `;
            openPanel('Edit place', html);
            document.getElementById('pl_save').addEventListener('click', async () => {
                const name = (document.getElementById('pl_name').value || '').trim();
                if (!name) { alert('Name is required'); return; }
                const description = (document.getElementById('pl_desc').value || '').trim() || null;
                const x = parseFloat(document.getElementById('pl_x').value);
                const y = parseFloat(document.getElementById('pl_y').value);
                await api.put(`/api/places/${place.id}`, { name, description, x, y });
                await reloadData();
                closePanel();
            });
            document.getElementById('pl_cancel').addEventListener('click', () => closePanel());
        }

        function openTravelEditPanel(travel) {
            const options = (selectedId) => {
                const none = `<option value="">(none)</option>`;
                const opts = places.map(pl => `<option value="${pl.id}" ${selectedId===pl.id? 'selected':''}>${pl.name}</option>`).join('');
                return none + opts;
            };
            const html = `
                <div class="panel-section">
                    <h5>Edit travel</h5>
                    <label>Name<br><input id="tr_name" type="text" value="${(travel.name || '').replaceAll('"','&quot;')}" style="width:100%"></label>
                </div>
                <div class="panel-section" style="display:flex; gap:8px">
                    <label style="flex:1">Type<br><input id="tr_type" type="text" value="${(travel.type || '').replaceAll('"','&quot;')}" style="width:100%"></label>
                    <label style="flex:1">Color<br><input id="tr_color" type="text" value="${(travel.color || 'red').replaceAll('"','&quot;')}" style="width:100%"></label>
                </div>
                <div class="panel-section">
                    <label>Reason / notes<br><textarea id="tr_reason" rows="3" style="width:100%">${(travel.reason || '').replaceAll('<','&lt;')}</textarea></label>
                </div>
                <div class="panel-section" style="display:flex; gap:8px">
                    <label style="flex:1">From place<br><select id="tr_from" style="width:100%">${options(travel.from_place_id || null)}</select></label>
                    <label style="flex:1">To place<br><select id="tr_to" style="width:100%">${options(travel.to_place_id || null)}</select></label>
                </div>
                <div class="panel-section mono" style="opacity:.8">Path points: ${Array.isArray(travel.path)? travel.path.length: 0} (use Redraw to edit geometry)</div>
                <div class="panel-actions">
                    <button id="tr_save">💾 Save</button>
                    <button id="tr_cancel">Cancel</button>
                </div>
            `;
            openPanel('Edit travel', html);
            document.getElementById('tr_save').addEventListener('click', async () => {
                const name = (document.getElementById('tr_name').value || '').trim() || null;
                const type = (document.getElementById('tr_type').value || '').trim() || null;
                const color = (document.getElementById('tr_color').value || '').trim() || 'red';
                const reason = (document.getElementById('tr_reason').value || '').trim() || null;
                const fromRaw = document.getElementById('tr_from').value;
                const toRaw = document.getElementById('tr_to').value;
                const from_place_id = fromRaw ? Number(fromRaw) : null;
                const to_place_id = toRaw ? Number(toRaw) : null;
                const payload = { name, type, color, reason, path: travel.path, from_place_id, to_place_id };
                await api.put(`/api/travels/${travel.id}`, payload);
                await reloadData();
                closePanel();
            });
            document.getElementById('tr_cancel').addEventListener('click', () => closePanel());
        }

        // --- Actions exposed to panel buttons ---
        window.addVisit = function(placeId) {
            const place = places.find(p => p.id === placeId);
            if (!place) return;
            const travelOptions = '<option value="">None</option>' + travels.map(t => `<option value='${t.id}'>${t.name || t.type || ('Travel #' + t.id)}</option>`).join('');
            const html = `
                <div class='panel-section'><h5>New visit at ${place.name}</h5>
                    <label>Travel number<br><input id='nv_num' type='number' style='width:100%'></label>
                </div>
                <div class='panel-section' style='display:flex; gap:8px'>
                    <label style='flex:1'>Travel<br><select id='nv_travel' style='width:100%'>${travelOptions}</select></label>
                </div>
                <div class='panel-section'>
                    <label>Reason (supports - bullets & newlines)<br><textarea id='nv_reason' rows='5' style='width:100%'></textarea></label>
                </div>
                <div class='panel-section'>
                    <label>Story time<br><input id='nv_story' type='text' style='width:100%'></label>
                </div>
                <div class='panel-actions'>
                    <button id='nv_save'>💾 Save</button>
                    <button id='nv_cancel'>Cancel</button>
                </div>
            `;
            openPanel('Add visit', html);
            document.getElementById('nv_save').addEventListener('click', async () => {
                const travel_number_raw = document.getElementById('nv_num').value;
                const travel_number = travel_number_raw === '' ? null : Number(travel_number_raw);
                const travel_id_raw = document.getElementById('nv_travel').value;
                const travel_id = travel_id_raw ? Number(travel_id_raw) : null;
                const reason = (document.getElementById('nv_reason').value || '').trim() || null;
                const story_time = (document.getElementById('nv_story').value || '').trim() || null;
                if (!reason) { alert('Reason required'); return; }
                await api.post('/api/place-visits', { place_id: placeId, travel_id, travel_number, reason, story_time });
                await reloadData();
                const pv = await api.get(`/api/places/${place.id}/visits`);
                openPlacePanel(place, pv);
            });
            document.getElementById('nv_cancel').addEventListener('click', async () => {
                const pv = await api.get(`/api/places/${place.id}/visits`);
                openPlacePanel(place, pv);
            });
        };

        window.deleteVisit = async function(visitId, placeId) {
            if (!confirm('Delete this visit?')) return;
            await api.del(`/api/place-visits/${visitId}`);
            await reloadData();
            if (placeId) {
                const p = places.find(pp => pp.id === placeId);
                if (p) {
                    const pv = await api.get(`/api/places/${p.id}/visits`);
                    openPlacePanel(p, pv);
                }
            }
        };

        window.editPlace = function(placeId) {
            const p = places.find(pp => pp.id === placeId);
            if (!p) return;
            openPlaceEditPanel(p);
        };

        window.deletePlace = async function(placeId) {
            if (!confirm('Delete this place (and its visits)?')) return;
            await api.del(`/api/places/${placeId}`);
            await reloadData();
        };

        window.startTravelFrom = function(placeId) {
            const p = places.find(pp => pp.id === placeId);
            if (!p) return;
            cleanupDrawing();
            setMode('drawTravel');
            drawState.startPlace = p;
            drawState.points = [[p.y, p.x]];
            drawState.tempLine = L.polyline(drawState.points, { color: '#555', dashArray: '4,4', weight: 3 }).addTo(travelsLayer);
            setMode('drawTravel');
        };

        window.openVisitEdit = async function(visitId) {
            // Try to get from global visits first (has relations); fallback to fetch
            let visit = visits.find(v => v.id === visitId);
            if (!visit) {
                try { visit = await api.get(`/api/place-visits/${visitId}`); } catch(e) { console.error(e); }
            }
            if (!visit) return alert('Visit not found');
            const placeOptions = places.map(pl => `<option value='${pl.id}' ${pl.id===visit.place_id? 'selected':''}>${pl.name}</option>`).join('');
            const travelOptions = `<option value=''>None</option>` + travels.map(t => `<option value='${t.id}' ${visit.travel_id===t.id? 'selected':''}>${t.name || t.type || ('Travel #' + t.id)}</option>`).join('');
            const html = `
                <div class='panel-section'><h5>Edit visit</h5>
                    <label>Travel number<br><input id='vis_num' type='number' value='${visit.travel_number != null ? visit.travel_number : ''}' style='width:100%'></label>
                </div>
                <div class='panel-section' style='display:flex; gap:8px'>
                    <label style='flex:1'>Place<br><select id='vis_place' style='width:100%'>${placeOptions}</select></label>
                    <label style='flex:1'>Travel<br><select id='vis_travel' style='width:100%'>${travelOptions}</select></label>
                </div>
                <div class='panel-section'>
                    <label>Reason<br><textarea id='vis_reason' rows='2' style='width:100%'>${(visit.reason || '').replaceAll('<','&lt;')}</textarea></label>
                </div>
                <div class='panel-section'>
                    <label>Story time<br><input id='vis_story' type='text' value='${(visit.story_time || '').replaceAll("'","&#39;")}' style='width:100%'></label>
                </div>
                <div class='panel-actions'>
                    <button id='vis_save'>💾 Save</button>
                    <button id='vis_cancel'>Cancel</button>
                </div>
            `;
            openPanel('Edit visit', html);
            document.getElementById('vis_save').addEventListener('click', async () => {
                const travel_number_raw = document.getElementById('vis_num').value;
                const travel_number = travel_number_raw === '' ? null : Number(travel_number_raw);
                const place_id = Number(document.getElementById('vis_place').value);
                const travel_id_raw = document.getElementById('vis_travel').value;
                const travel_id = travel_id_raw ? Number(travel_id_raw) : null;
                const reason = (document.getElementById('vis_reason').value || '').trim() || null;
                const story_time = (document.getElementById('vis_story').value || '').trim() || null;
                await api.put(`/api/place-visits/${visit.id}`, { place_id, travel_id, travel_number, reason, story_time });
                await reloadData();
                // Re-open place panel for new place after save
                const p = places.find(pp => pp.id === place_id);
                if (p) {
                    const pv = await api.get(`/api/places/${p.id}/visits`);
                    openPlacePanel(p, pv);
                } else {
                    closePanel();
                }
            });
            document.getElementById('vis_cancel').addEventListener('click', () => {
                // If we have original place, reopen
                const p = places.find(pp => pp.id === visit.place_id);
                if (p) {
                    api.get(`/api/places/${p.id}/visits`).then(pv => openPlacePanel(p, pv));
                } else {
                    closePanel();
                }
            });
        };

        async function finishTravelDialog() {
            if (drawState.points.length < 2) { alert('Add at least two points.'); return; }
            let defaultName = null;
            if (drawState.startPlace && drawState.endPlace) {
                defaultName = `Connection between ${drawState.startPlace.name} and ${drawState.endPlace.name}`;
            }
            const name = prompt('Travel name? (optional)', defaultName || '') || (defaultName || null);
            const type = prompt('Type? (e.g., Carriage, Ship)') || null;
            const color = prompt('Color? (CSS color or hex, default red)', 'red') || 'red';
            const reason = prompt('Reason/notes?') || null;
            const path = drawState.points;
            const payload = { name, type, color, reason, path };
            if (drawState.startPlace) payload.from_place_id = drawState.startPlace.id;
            if (drawState.endPlace) payload.to_place_id = drawState.endPlace.id;
            const created = await api.post('/api/travels', payload);

            // Offer to log this traversal as an occurrence in the story sequence
            const log = confirm('Log this traversal in the sequence (create a visit at the destination with a travel number)?');
            if (log) {
                const travelNum = prompt('Travel number? (sequence order)');
                const storyTime = prompt('When in story?') || null;
                const visitReason = reason || prompt('Reason for visit?') || null;
                if (drawState.endPlace && travelNum) {
                    await api.post('/api/place-visits', { place_id: drawState.endPlace.id, travel_id: created.id, travel_number: Number(travelNum), story_time: storyTime, reason: visitReason });
                }
            }
            setMode('view');
            await reloadData();
        }

        window.editTravel = function(travelId) {
            const t = travels.find(tt => tt.id === travelId);
            if (!t) return;
            openTravelEditPanel(t);
        };

        window.redrawTravel = async function(travelId) {
            const t = travels.find(tt => tt.id === travelId);
            if (!t) return;
            cleanupDrawing();
            setMode('drawTravel');
            // Seed with first point of existing path as start
            drawState.startPlace = null; // allow free redraw (no enforced start place)
            drawState.points = [ ...t.path ];
            drawState.tempLine = L.polyline(drawState.points, { color: '#555', dashArray: '4,4', weight: 3 }).addTo(travelsLayer);
            helpTip.textContent = 'Redraw: click to add points; press Finish to save or Cancel to discard.';
            const proceed = confirm('Overwrite this travel path? Click OK to start adding points. Use Finish to save or Cancel to discard.');
            if (!proceed) { setMode('view'); return; }
            finishHook = async () => {
                if (drawState.points.length < 2) { alert('Add at least two points.'); return; }
                await api.put(`/api/travels/${t.id}`, { name: t.name, type: t.type, color: t.color, reason: t.reason, path: drawState.points });
                finishHook = null;
                setMode('view');
                await reloadData();
            };
        };

        window.deleteTravel = async function(travelId) {
            if (!confirm('Delete this travel?')) return;
            await api.del(`/api/travels/${travelId}`);
            await reloadData();
        };

        // Storyboard buttons removed per request; numbers appear on roads and places instead.

        // Initial load
        reloadData();
    </script>
</body>
</html>
