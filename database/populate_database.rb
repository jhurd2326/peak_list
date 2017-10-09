# frozen_string_literal: true

#  Assumes specified database contains a mountains table with the following schema
#
#  +-----------+-----------+------+-----+---------+----------------+
#  | Field     | Type      | Null | Key | Default | Extra          |
#  +-----------+-----------+------+-----+---------+----------------+
#  | id        | int(11)   | NO   | PRI | NULL    | auto_increment |
#  | name      | char(255) | YES  |     | NULL    |                |
#  | state     | char(255) | YES  |     | NULL    |                |
#  | country   | char(255) | YES  |     | NULL    |                |
#  | latitude  | char(255) | YES  |     | NULL    |                |
#  | longitude | char(255) | YES  |     | NULL    |                |
#  | elevation | int(11)   | YES  |     | NULL    |                |
#  +-----------+-----------+------+-----+---------+----------------+

require_relative "mountain"
require "active_record"
require "mysql2"
require "json"
require "pry-rails"

if ARGV.empty?
  puts "Usage: #{$PROGRAM_NAME} json_file"
  exit 1
end

ActiveRecord::Base.establish_connection(
  adapter: "mysql2",
  database: "cpsc_4620",
  username: "root",
  host: "localhost",
  encoding: "utf8",
)

mountains = JSON.parse(File.read(ARGV[0]))
Mountain.connection

mountains.each do |m|
  next if m["state"].nil?
  Mountain.create(name: m["name"], state: m["state"], country: Mountain.select_country(m["state"]),
                  latitude: m["lat"], longitude: m["lon"], elevation: m["ele"])
end
