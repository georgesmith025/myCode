#Model used for users login
require_relative "../helpers/Validation"
require_relative "../db/db" 

class User < Sequel::Model
  
  def loadParams(params)
      #loads params given by form
      self.username = params.fetch("username", "").strip
      self.password = params.fetch("password", "").strip
      self.first_name = params.fetch("first_name", "").strip
      self.surname = params.fetch("surname", "").strip
      self.account_type = params.fetch("account_type", "").strip
      self.area_of_focus = params.fetch("area_of_focus", "").strip
      self.email = params.fetch("email", "").strip
      self.bio = params.fetch("bio", "").strip
  end

  def validate
    super
    errors.add("username", "cannot be empty") if username.empty?
    errors.add("password", "cannot be empty") if password.empty?
    errors.add("first_name", "cannot be empty") if first_name.empty?
	errors.add("surname", "cannot be empty") if surname.empty?
    errors.add("account_type", "cannot be empty") if account_type.empty?
    errors.add("area_of_focus", "cannot be empty") if area_of_focus.empty?
    errors.add("email", "cannot be empty") if email.empty?
    errors.add("email", "has to have a registered university domain, e.g. sheffield.ac.uk") if emailCheck
    errors.add("bio", "cannot be empty") if bio.empty?
  end
   
  def emailCheck
      if account_type == "Mentee"
          emails = ["@sheffield.ac.uk", "@leeds.ac.uk", "@ncl.ac.uk", "@liverpool.ac.uk", "@nottingham.ac.uk", "@shu.ac.uk"]
          for i in (0..emails.length - 1) 
              if email.include?(emails[i].to_s)
                  return false
              end
          end
          return true
      end
  end
      
  def lookup  
      userLookup = User.first(username: username)
      if !userLookup.nil? && userLookup.password == password
          return true
      end
      return false
  end
    
  def loginLoad(params)
      self.username = params.fetch("username", "").strip
      self.password = params.fetch("password", "").strip
  end
    
  def loginValidate
     if username.empty? || password.empty?
         return false
     end
     return true
  end
    
  def self.id_exists?(id)
		return false if id.nil? # check the id is not nil
		return false unless Validation.str_is_integer?(id) # check the id is an integer
		return false if User[id].nil? # check the database has a record with this id
		true # all checks are ok - the id exists
  end
    
  def getUsername
      return self.username
  end
    
  def getAccountType
      return self.account_type
  end
    
end