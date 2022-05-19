get "/request" do
    @mentor = params["mentor"]
    @mentee = request.cookies["username"]    
    matches = DB[:matches]
    currentMatches = matches.where(mentee: @mentee, mentor: @mentor)
    
    if currentMatches.count == 0
     matches.insert(mentee: @mentee, mentor: @mentor, status: "Pending")
     @status = "new"
    else
     @status = "old"
    end
    
    puts @status
    
    dataset = DB[:Users].where(username: @mentor)  
    @mentorName = dataset.first[:first_name]+" "+dataset.first[:surname]
    
    erb :request
end