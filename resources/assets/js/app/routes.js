//Collect all of the routes and export it togeother
import auth from './auth/routes'
import home from './home/routes'
import metadata from './metadata/routes'

export default [...home, ...auth, ...metadata]