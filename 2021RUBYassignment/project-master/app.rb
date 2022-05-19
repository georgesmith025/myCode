require "sinatra"
require "sinatra/reloader"
require "sequel"
require "require_all"

set :bind, "0.0.0.0"

# Database
require_relative "db/db"

# So we can escape HTML special characters in the view
include ERB::Util

# Sessions for login
enable :sessions
set :session_secret, "t7w!z%C*F)J@NcRfUjXn2r5u8x/A?D(G"


require_all "controllers"
require_all "models"



