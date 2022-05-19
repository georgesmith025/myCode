get "/matches" do
    
    @account_type = request.cookies.fetch("account_type","N/A")
    
    if @account_type == "Mentee"
        @target = "Mentor"
        @title = "Mentor List"
    
    elsif @account_type == "Mentor"
        @target = "Mentee"
        @title = "Interested Mentees"
    
    else
        # Admin account goes to usersData
        redirect "/usersData"
    end

    
    @AoF_search = params.fetch("AoF_search", " ").strip

    @user = if @AoF_search.empty?
               User.where(Sequel.ilike(:account_type,"%#{@target}"))
             else
               User.where(Sequel.ilike(:area_of_focus, "%#{@AoF_search}%"))
               # Bit of a botch here, but it also checks if target is correct
               # in the loop when generating the table but it works - Dan
             end

    erb :search
end