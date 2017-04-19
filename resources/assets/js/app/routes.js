//Collect all of the routes and export it togeother
import auth from './auth/routes'
import home from './home/routes'
import users from './users/routes'
import errors from './errors/routes'
import metadata from './metadata/routes'
import locations from './locations/routes'
import listofvalues from './listofvalues/routes'
import authorization from './authorization/routes'

export default [...home, ...auth, ...metadata, ...listofvalues, ...users, ...authorization, ...locations, ...errors]