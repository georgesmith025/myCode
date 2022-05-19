get "/confirmation" do
    #finds list of users needing confirmation
    @mentor = request.cookies["username"] 
    @mentee = params["mentee"]
    @status = params["status"]
    matches = DB[:matches]
    match = matches.where(mentee: @mentee, mentor: @mentor)
    
    match.update(:status => @status)
    
    #displays users
    dataset = DB[:Users].where(username: @mentee)  
    @menteeName = dataset.first[:first_name]+" "+dataset.first[:surname]
    
    erb :confirmation
end