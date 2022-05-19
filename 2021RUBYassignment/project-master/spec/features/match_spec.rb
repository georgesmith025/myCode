require_relative "../spec_helper"
RSpec.describe do
    describe "requesting a mentor" do
        context "when a mentee selects request"
          it "confirms the request" do
            add_test_mentee
            add_test_mentor
            visit "/login"
            fill_in "username", with: "mentee1"
            fill_in "password", with: "password"
            click_button "Submit"
            visit "/request?mentor=mentor1"
            expect(page).to have_content "You have requested contact with"
         end
        context "when a mentee has already requested a mentor"
          it "tells the mentee it has already requested" do
            add_test_mentee
            add_test_mentor
            visit "/login"
            fill_in "username", with: "mentee1"
            fill_in "password", with: "password"
            click_button "Submit"
            visit "/request?mentor=mentor1"
            visit "/request?mentor=mentor1"
            expect(page).to have_content "You have already requested contact with"
          end
    end
    describe "viewing potential matches" do
        context "mentee visits mentors page"
          it "will show potential mentors" do
            add_test_mentee
            add_test_mentor
            visit "/login"
            fill_in "username", with: "mentee1"
            fill_in "password", with: "password"
            click_button "Submit"
            click_on "Mentors"
            expect(page).to have_content "Mentor One"
          end
        context "mentor visits dashboard"
          it "will show mentees who have requested a meeting" do
            add_test_mentor
            add_test_mentee
            visit "/login"
            fill_in "username", with: "mentee1"
            fill_in "password", with: "password"
            click_button "Submit"
            visit "/request?mentor=mentor1"
            visit "/logout"
            fill_in "username", with: "mentor1"
            fill_in "password", with: "password"
            click_button "Submit"
            expect(page).to have_content "mentee1"
          end
          it "will allow mentors to reject a mentee" do
            add_test_mentor
            add_test_mentee
            visit "/login"
            fill_in "username", with: "mentee1"
            fill_in "password", with: "password"
            click_button "Submit"
            visit "/request?mentor=mentor1"
            visit "/logout"
            fill_in "username", with: "mentor1"
            fill_in "password", with: "password"
            click_button "Submit"
            click_on 'Reject'
            expect(page).to have_content "Rejected"
          end
          it "will allow mentors to accept a mentee" do 
            add_test_mentor
            add_test_mentee2
            visit "/login"
            fill_in "username", with: "mentee2"
            fill_in "password", with: "password"
            click_button "Submit"
            visit "/request?mentor=mentor1"
            visit "/logout"
            fill_in "username", with: "mentor1"
            fill_in "password", with: "password"
            click_button "Submit"
            click_on 'Accept'
            expect(page).to have_content "Accepted"
          end
    end

end
