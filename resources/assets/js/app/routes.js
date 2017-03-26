//Collect all of the routes and export it togeother
import auth from './auth/routes'
import home from './home/routes'
import metadata from './metadata/routes'
import errors from './errors/routes'

export default [...home, ...auth, ...metadata, ...errors]