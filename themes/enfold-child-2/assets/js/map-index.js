console.log('***map pong***')

const [map, bounds, infowindow] = initMap()

// const `points` is loaded in WP template
const pointsHot = extractSaleSet(points)
loadPoints(points, map, bounds, pointsHot, infowindow)
setViewport(bounds, map)
