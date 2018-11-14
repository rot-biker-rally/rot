console.log('***map ping***')

function initMap() {
    const map = new google.maps.Map(document.getElementById('map'), {
        styles: map_style // loaded in WP enqueue
    })
    const bounds = new google.maps.LatLngBounds()
    const infowindow = new google.maps.InfoWindow()
    return [map, bounds, infowindow]
}

function buildIcon(liveMarker) {
    const handles = ['fillColor', 'fillOpacity', 'strokeColor', 'strokeOpacity', 'strokeWeight']
    const styles = liveMarker ?
    ['orange', 1, 'orange', 1, 1] :
    ['gray', 1, 'gray', 1, 1]
    const icon = {
        path: google.maps.SymbolPath.CIRCLE,
        scale: 2
    }
    for (const i in handles) {
        icon[handles[i]] = styles[i]
    }
    return icon
}

function attachInfoWindow(marker, infowindow, p) {
    marker.addListener('click', () => {
        infowindow.setContent(
            `<h3>${p.title}</h3>`+
            `<a class="button" href="${p.link}" target="_blank">Buy Now</a>`
        )
        infowindow.open(map, marker)
    })
}

function loadPoints(points, map, bounds, infowindow) {
    points.forEach(p => {
        let iconStyle
        const latLng = new google.maps.LatLng(p.lat, p.lon)
        bounds.extend(latLng)
        const liveMarker = Boolean(p.renewable == 0 && p.stock == 1)
        const marker = new google.maps.Marker({
            position: latLng,
            icon: buildIcon(liveMarker),
            map
        })
        if (liveMarker) {
            attachInfoWindow(marker, infowindow, p)
        }
    })
}

function setViewport(bounds, padding) {
    map.fitBounds(bounds, padding)
}


const [map, bounds, infowindow] = initMap()
// const `points` is loaded in WP template
loadPoints(points, map, bounds, infowindow)
setViewport(bounds, 5)
