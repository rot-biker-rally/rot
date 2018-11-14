console.log('***map pong***')

const [map, bounds] = initMap()

// const `points` and `pointsHot`are loaded in WP template
loadPoints(points, map, bounds, pointsHot, null, false)
setViewport(bounds, map, true)
