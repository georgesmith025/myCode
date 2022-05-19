get "/login" do
    #checks to see if user is already logged in and redirects to dashboard if so
    if session[:logged_in]
        redirect "/dashboard"
    end
    #else displays login page
    @title = "Login Page"
    erb :login
end

post "/login" do
    #Used to validate information given by user
    #Need to implement check against the users database
    id = params["username"]
    @User = User.new
    @User.loadParams(params)
    @error = ""
    
    if @User.loginValidate
        if @User.lookup
            session[:logged_in] = true

            response.set_cookie("username", @User.getUsername)
            
            dataset = DB[:Users].where(username: @User.getUsername)
            dataset.each do |save|
                @name = save[:first_name]+" "+save[:surname]
                @accountType = save[:account_type]
                @areaOfFocus = save[:area_of_focus]
            end
            response.set_cookie("account_type", @accountType)
            response.set_cookie("name", @name)
            response.set_cookie("area_of_focus", @areaOfFocus)
            redirect "/dashboard"
        else 
            @error = "Either username or password was incorrect."
        end
    else
        @error = "Enter username and password."
    end
        
    erb:login
    
end

get "/dashboard" do
    @title = "Dashboard"
    
    @account_type = request.cookies["account_type"]
    user = request.cookies["username"]
    
    if @account_type == "Mentor"
      @matchesDataset = DB[:matches].where(mentor: user)
    elsif @account_type == "Mentee"
      @matchesDataset = DB[:matches].where(mentee: user)
    end
    
    erb :dashboard
end

get "/logout" do
    #clears the current users session and redirects to login page
    response.delete_cookie("id")
    response.delete_cookie("username")
    response.delete_cookie("account_type")
    response.delete_cookie("area_of_focus")
    response.delete_cookie("name")
    session[:logged_in] = false
    session.clear
    
    redirect "/login"
end
