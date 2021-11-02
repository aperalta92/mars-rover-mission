import RoverRepository from './RoverRepository';
import MapRepository from './MapRepository';

const repositories = {
    "rover": RoverRepository,
    "map": MapRepository
}

export default {
    get: (name) => repositories[name]
}
