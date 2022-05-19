# Configure coverage logging
require "simplecov"
SimpleCov.start do
  add_filter "/spec/"
end
SimpleCov.coverage_dir "coverage"

# Ensure we use the test database
ENV["APP_ENV"] = "usersTesting"

# load the app
require_relative "../app"

# Configure Capybara
require "capybara/rspec"
Capybara.app = Sinatra::Application

# Configure RSpec
def app
  Sinatra::Application
end
RSpec.configure do |config|
  config.include Capybara::DSL
  config.include Rack::Test::Methods
end

# add a test player
def add_test_user
  visit "/create-account"
  fill_in "first_name", with: "Test"
  fill_in "surname", with: "Person"
  fill_in "username", with: "DaTester"
  fill_in "password", with: "Test123"
  fill_in "bio", with: "I like testing things."
  click_button "Submit"
end

def add_test_mentee
  visit "/create-account"
  select 'Mentee', from: 'account_type'
  select "Computer Science", from: "area_of_focus"
  fill_in "first_name", with: "Mentee"
  fill_in "surname", with: "One"
  fill_in "username", with: "mentee1"
  fill_in "password", with: "password"
  fill_in "email", with: "mentee1@sheffield.ac.uk"
  fill_in "bio", with: "bio of first mentee."
  click_button "Submit"
end

def add_test_mentee2
  visit "/create-account"
  select 'Mentee', from: 'account_type'
  select "Computer Science", from: "area_of_focus"
  fill_in "first_name", with: "Mentee"
  fill_in "surname", with: "Two"
  fill_in "username", with: "mentee2"
  fill_in "password", with: "password"
  fill_in "email", with: "mentee2@sheffield.ac.uk"
  fill_in "bio", with: "bio of second mentee."
  click_button "Submit"
end

def add_test_mentor
  visit "/create-account"
  select 'Mentor', from: 'account_type'
  select "Computer Science", from: "area_of_focus"
  fill_in "first_name", with: "Mentor"
  fill_in "surname", with: "One"
  fill_in "username", with: "mentor1"
  fill_in "password", with: "password"
  fill_in "email", with: "mentor1@sheffield.ac.uk"
  fill_in "bio", with: "bio of first mentor."
  click_button "Submit"
end

def mentee_login
    visit "/login"
    fill_in "username", with: "mentee1"
    fill_in "password", with: "password"
    click_button "Submit"
end
# clear out the database
def clear_database
  DB.from("users").delete
  DB.from("matches").delete
end

def add_admin
    DB[:users].insert(username: "admin", password: "password", account_type: "Admin",
        area_of_focus: "Computer Science", email: "admin@sheffield.ac.uk", bio: "admin",
        first_name: "admin", surname: "admin")
end
# ensure we're always starting from a clean database
clear_database

