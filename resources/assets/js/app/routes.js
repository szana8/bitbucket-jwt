//Collect all of the routes and export it togeother
import auth from './auth/routes'
import home from './home/routes'
import metadata from './metadata/routes'
import listofvalues from './listofvalues/routes'
import authorization from './authorization/routes'
import locations from './locations/routes'
import user from './user/routes'
import errors from './errors/routes'

export default [...home, ...auth, ...metadata, ...listofvalues, ...user, ...authorization, ...locations, ...errors]