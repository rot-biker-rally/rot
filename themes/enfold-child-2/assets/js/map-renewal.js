console.log('***map pong***')

const [map, bounds, infowindow] = initMap()

// const `points`, `pointsHot`, `rkey` are loaded in WP template
loadPoints(points, map, bounds, pointsHot, infowindow, false, rkey)
setViewport(bounds, map, true)
