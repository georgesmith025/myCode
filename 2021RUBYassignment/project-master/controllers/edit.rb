get "/edit" do
  id = params["id"]
  @user = User[id] if User.id_exists?(id)
  erb :edit
end

post "/edit" do
  
  #grabs parameters for id and checks account type
  #redirects to users list for admin after changes are saved
  id = params["id"]
  @user = User[id] if User.id_exists?(id)
  
  @account_type = request.cookies.fetch("account_type","N/A")
    
  id = params["id"]

  if User.id_exists?(id)
    @user = User[id]
    @user.loadParams(params)

    if @user.valid?
      @user.save_changes
      
      if @account_type == "Mentee" or @account_type == "Mentor"
          redirect "/profilePage"
      
      else
          redirect "/users"
      end
        
    end
      
  end
    erb :edit
end