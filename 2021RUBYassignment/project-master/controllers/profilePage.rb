get "/profilePage" do
    
    # Grabs userName from the cookie and checks it with DB
    @userName = request.cookies.fetch("username","N/A")

    dataset = DB[:Users].where(username: @userName)

    dataset.each do |save|
        @name = save[:first_name]+" "+save[:surname]
        @accountType = save[:account_type]
        @email = save[:email]
        @areaOfFocus = save[:area_of_focus]
        @bio = save[:bio]
        @id = save[:id]
    end
    
    @user = User.all
    
    @title = @accountType + " profile page"
    
    erb :profilePage

end


get "/editProfile" do
  id = params["id"]
  @user = User[id] if User.id_exists?(id)
  erb :editProfile
end


post "/editProfile" do
  id = params["id"]
  if User.id_exists?(id)
    @user = User[id]
    @user.loadParams(params)

    if @user.valid?
      @user.save_changes
      redirect "/profilePage"
    end
  end
    
end