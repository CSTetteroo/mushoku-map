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
        }
        .road-badges .badge {
            display: inline-block;
            min-width: 18px; height: 18px; line-height: 18px;
            margin: 0 2px; padding: 0 4px;
            border-radius: 9px; background: #222; color: #fff; font-size: 12px; font-weight: 700;
            text-align: center; border: 1px solid #fff;
        }
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
            const placedBadgeCenters = [];

            // Render travels grouped by exact path match so identical geometries merge (show combined numbers)
            const travelGroups = groupTravelsByPath(travels);
            travelGroups.forEach(group => {
                const rep = group.travels[0];
                const line = L.polyline(rep.path, { color: rep.color || 'red', weight: 3 }).addTo(travelsLayer);
                line.group = group; // attach

                // Build popup that lists each travel in this group (so edit/delete per travel still available)
                const travelItemsHtml = group.travels.map(t => {
                    return `<div style="margin-bottom:6px"><span class=\"color-dot\" style=\"background:${t.color || 'red'}\"></span><b>${t.name || t.type || 'Travel #' + t.id}</b><div>${t.type ? ('Type: ' + t.type) : ''}</div><div>${t.reason || ''}</div><div><button onclick=\"editTravel(${t.id})\">✏️ Edit</button> <button onclick=\"redrawTravel(${t.id})\">🖊️ Redraw</button> <button onclick=\"deleteTravel(${t.id})\">🗑️ Delete</button></div></div>`;
                }).join('');
                const info = `<div>${travelItemsHtml}</div>`;
                line.bindPopup(info);

                // Add aggregated travel number badges on the road if any of these travels have visits
                const numbers = [];
                group.travels.forEach(t => {
                    const nums = visitsByTravel[t.id] || [];
                    nums.forEach(n => { if (!numbers.includes(n)) numbers.push(n); });
                });
                numbers.sort((a,b) => a-b);
                if (numbers.length) {
                    const center = line.getBounds().getCenter();
                    const pos = resolveBadgePosition([center.lat, center.lng], placedBadgeCenters);
                    placedBadgeCenters.push(pos);
                    const html = `<div class="road-badges">${numbers.map(n => `<span class=\"badge\">${n}</span>`).join('')}</div>`;
                    const icon = L.divIcon({ className: 'road-badges', html, iconSize: null });
                    L.marker(pos, { icon, interactive: false, keyboard: false }).addTo(travelsLayer);
                }
            });

            // Render places
            places.forEach(p => {
                const m = L.marker([p.y, p.x], { draggable: true }).addTo(markersLayer);
                m.place = p;
                // Number label(s) (permanent tooltip) if exist
                if (placeLabels[p.id] && placeLabels[p.id].length) {
                    const text = placeLabels[p.id].join(', ');
                    m.bindTooltip(text, { permanent: true, direction: 'top', className: 'place-number', offset: [0, -16] }).openTooltip();
                }

                m.on('dragend', async (e) => {
                    const pos = e.target.getLatLng();
                    await api.put(`/api/places/${p.id}`, { name: p.name, description: p.description, x: pos.lng, y: pos.lat });
                    await reloadData();
                });

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

                    const visits = await api.get(`/api/places/${p.id}/visits`);
                        const html = `
                            <div>
                                <b>${p.name}</b><br>${p.description || ''}<hr>
                                <b>Visits:</b><br>
                                ${visits.length ? visits.map(v => `<div><b>#${v.travel_number || '-'}</b> ${v.reason || ''} <i>${v.story_time || ''}</i> <button onclick=\"deleteVisit(${v.id})\">🗑 Remove</button></div>`).join('') : 'No visits yet.'}
                                <hr>
                                <button onclick="addVisit(${p.id})">➕ Add Visit</button>
                                <button onclick="editPlace(${p.id})">✏️ Edit Place</button>
                                <button onclick="deletePlace(${p.id})">🗑️ Delete Place</button>
                                <button onclick="startTravelFrom(${p.id})">🧭 Start Travel here</button>
                            </div>`;
                    m.bindPopup(html).openPopup();
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

        // --- Actions exposed to popups ---
        window.addVisit = async function(placeId) {
            const travelNum = prompt('Travel number?');
            const reason = prompt('Reason?');
            const storyTime = prompt('When in story?');
            if (!reason) return alert('Cancelled.');
            await api.post('/api/place-visits', { place_id: placeId, travel_number: travelNum ? Number(travelNum) : null, reason, story_time: storyTime || null });
            await reloadData();
        };

        window.deleteVisit = async function(visitId) {
            if (!confirm('Delete this visit?')) return;
            await api.del(`/api/place-visits/${visitId}`);
            await reloadData();
        };

        window.editPlace = async function(placeId) {
            const p = places.find(pp => pp.id === placeId);
            if (!p) return;
            const name = prompt('Place name:', p.name);
            if (!name) return;
            const description = prompt('Description:', p.description || '') || null;
            await api.put(`/api/places/${p.id}`, { name, description, x: p.x, y: p.y });
            await reloadData();
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

        window.editTravel = async function(travelId) {
            const t = travels.find(tt => tt.id === travelId);
            if (!t) return;
            const name = prompt('Travel name:', t.name || '') || null;
            const type = prompt('Type:', t.type || '') || null;
            const color = prompt('Color:', t.color || 'red') || 'red';
            const reason = prompt('Reason/notes:', t.reason || '') || null;
            await api.put(`/api/travels/${t.id}`, { name, type, color, reason, path: t.path });
            await reloadData();
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
