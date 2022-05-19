require_relative "../spec_helper.rb"


describe "the login page" do
    it "will not attempt login without both fields entered" do
        visit "/login"
        click_button "Submit"
        expect(page).to have_content "Enter username and password."
    end
    
    it "will not attempt login with one field entered" do
        add_test_mentor
        visit "/login"
        fill_in "username", with: "mentor1"
        click_button "Submit"
        expect(page).to have_content "Enter username and password."
    end
    
    it "will not login with invalid username and password" do
        add_test_mentor
        visit "/login"
        fill_in "username", with: "mentee"
        fill_in "password", with: "password"
        click_button "Submit"
        expect(page).to have_content "Either username or password was incorrect."
    end
    
    it "will login with valid username and password" do
        add_test_mentor
        visit "/login"
        fill_in "username", with: "mentor1"
        fill_in "password", with: "password"
        click_button "Submit"
        expect(page).to have_current_path("/dashboard")
    end
end

describe "logging out" do 
    it "will logout the user if logged in" do
        add_test_mentee
        fill_in "username", with: "mentee1"
        fill_in "password", with: "password"
        click_button "Submit"
        visit "/logout"
        expect(page).to have_current_path("/login")
    end
end

describe "viewing profile" do
    it "will allow the user to view their profile once logged in" do
        add_test_mentee
        fill_in "username", with: "mentee1"
        fill_in "password", with: "password"
        click_button "Submit"
        visit "/profilePage"
        expect(page).to have_content "Your Username: mentee1"
    end
end