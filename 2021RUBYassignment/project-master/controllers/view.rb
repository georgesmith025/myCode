get "/view" do
    
    @userName = params["user"]

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
    
    #if @userName != nil
    @title = @userName + "'s Profile Page"
    #end
    
    
    erb :view

end

