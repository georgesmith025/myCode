post "/delete" do
  #finds user id and delets account, redirecting back to users"
  id = params["id"]
  
  if User.id_exists?(id)
    user = User[id]
    user.delete
    
    #redirect to appropriate pages
    @account_type = request.cookies.fetch("account_type","N/A")
    if @account_type == "Admin"
      redirect "/users"
    else
      session[:logged_in] = false
      redirect "/login"
    end
  end

  erb :delete
end