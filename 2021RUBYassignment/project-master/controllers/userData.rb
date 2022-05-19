get "/users" do
    if request.cookies["account_type"] != "Admin" 
        redirect "/dashboard"
    end
    
    @title = "User Database"
    @username_search = params.fetch("username_search", "").strip

    @user = if @username_search.empty?
               User.all
             else
               User.where(Sequel.like(:username, "%#{@username_search}%"))
             end
    erb :usersData
end