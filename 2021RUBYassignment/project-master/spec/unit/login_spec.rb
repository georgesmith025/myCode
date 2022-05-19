require_relative "../spec_helper"

RSpec.describe "Login page" do
    it "does not accept no inputs in either fields" do
      post "/login", "username" => "", "password" => ""
      expect(last_response.body).to include("Enter username and password.")
    end
end
