require_relative "../spec_helper"

describe "the add page" do
  it "is accessible from the index page" do
    visit "/index"
    click_link "Create Account"
    expect(page).to have_content "Create Your Account"
  end

  it "will not add a user with no details" do
    
    visit "/create-account"
    click_button "Submit"
    expect(page).to have_content "Please correct the errors below"
  end

  it "adds a player when all details are entered" do
    visit "/create-account"
    add_test_mentee
    click_button "Submit"
    expect(page).to have_no_content "Create Your Account"
    clear_database
  end
end