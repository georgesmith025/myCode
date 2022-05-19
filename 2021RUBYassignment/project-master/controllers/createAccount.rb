get "/create-account" do
    @title = "Create Your Account"
    @user = User.new
    
    erb :create
end

post "/create-account" do
	@user = User.new
	@user.loadParams(params)
    
    #if the new user fulfills params, create account and redirect to the login page
	if @user.valid?
        @user.save_changes
		redirect "/login"
	end

  erb :create
end