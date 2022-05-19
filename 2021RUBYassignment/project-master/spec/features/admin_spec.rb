require_relative "../spec_helper"

RSpec.describe do
    describe "admin rights" do
        context "when logged in as mentee/mentor"
        it "will not allow you to view admin page" do
            clear_database
            add_test_mentee
            visit "/login"
            fill_in "username", with: "mentee1"
            fill_in "password", with: "password"
            click_button "Submit"
            visit "/users"
            expect(page).to have_current_path("/dashboard")
        end
        
        context "when logged in as admin"
        it "will display a list of users on admin page" do
            clear_database
            add_test_mentee
            add_admin
            visit "/login"
            fill_in "username", with: "admin"
            fill_in "password", with: "password"
            click_button "Submit"
            visit "/users"
            expect(page).to have_content "mentee1"
        end
        
        
        #it "will allow admins to delete accounts" do
         #   clear_database
          #  add_test_mentee
           # add_admin
         #   fill_in "username", with: "admin"
         #   fill_in "password", with: "password"
         #   click_button "Submit"
         #   visit "/edit?id=1"
         #   accept_confirm do
         #      click_button "Delete"
         #   end
         #   save_page
        #end
       
    end
end
    