console.log('***map ping***')

function initMap() {
    const map = new google.maps.Map(document.getElementById('map'), {
        styles: map_style // loaded in WP enqueue
    })
    const bounds = new google.maps.LatLngBounds()
    const infowindow = new google.maps.InfoWindow()
    return [map, bounds, infowindow]
}

function buildIcon(hot) {
    const handles = ['fillColor', 'fillOpacity', 'strokeColor', 'strokeOpacity', 'strokeWeight']
    const styles = hot ?
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

function extractSaleSet(points) {
    const res = [];
    points.forEach(p => {
        if(p.renewable == 0 && p.stock == 1) {
            res.push(p.sku)
        }
    })
    return res
}


function loadPoints(points, map, bounds, hots, infowindow=null, zoomAll=true) {
    points.forEach(p => {
        const latLng = new google.maps.LatLng(p.lat, p.lon)
        const hot = hots.includes(p.sku)
        if (zoomAll || hot) {
            bounds.extend(latLng)
        }
        const marker = new google.maps.Marker({
            position: latLng,
            icon: buildIcon(hot),
            map
        })
        if (hot && infowindow) {
            attachInfoWindow(marker, infowindow, p)
        }
    })
}

function setViewport(bounds, map, subset=false) {
    map.fitBounds(bounds, 10)
    if (subset) {
        google.maps.event.addListenerOnce(map, 'idle', () => {
          if (map.getZoom() != 18) map.setZoom(18)
      })
    }
}
