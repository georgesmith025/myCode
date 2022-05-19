get "/" do
    if session[:logged_in]
      redirect "/dashboard"
    else
      redirect "/login"
    end
end

get "/index" do
    erb :index
end
