# frozen_string_literal: true

# Takes in an OSM file containing just mountain peaks and parses the XML into JSON
# Openstreetmap.org's nominatim app is used for reverse geocoding the cooridinates
# and requires a contact email in the header of each request.  OSM asks to keep
# the requests at a maximum of one per second.

require "nokogiri"
require "json"
require "geocoder"

class MountainParser
  def initialize(infile, outfile, email)
    Geocoder.configure(lookup: :nominatim, http_headers: { "User-Agent" => email }, timeout: 10)
    @out = File.new(outfile, "w")
    @reader = Nokogiri::XML::Reader(File.new(infile))
    @count = 0
  end

  def perform
    @out.write "[\n"
    while @reader.nil? == false
      @reader = @reader.read
      parse
      sleep 1
    end
    @out.write "{}\n]\n"
    @out.close
  end

  def parse
    return unless (@reader.is_a? Nokogiri::XML::Reader) && @reader.name == "node"
    tags = %w(name ele)
    entry = build_entry
    return if entry.nil?
    parse_node(tags, entry)
  end

  def parse_node(tags, entry)
    while (@reader = @reader.read).nil? == false
      break if @reader.name == "node"
      next unless @reader.name == "tag"
      populate_entry_tags(tags, entry)
    end
    return unless tags.empty?
    @out.write("#{entry.to_json},\n")
    puts "#{@count += 1} #{entry}"
  end

  def build_entry
    latitude = @reader.attribute("lat")
    longitude = @reader.attribute("lon")
    geo_result = Geocoder.search([latitude, longitude])
    return if geo_result.nil?
    mountain = Geocoder.search([latitude, longitude]).first
    return if mountain.nil?
    { lat: latitude, lon: longitude, state: mountain.state }
  end

  def populate_entry_tags(tags, entry)
    key = @reader.attribute "k"
    return unless tags.include? key
    tags.delete(key)
    entry[key] = @reader.attribute "v"
  end
end

if ARGV.size < 3
  puts "Usage: #{$PROGRAM_NAME} osm_file output_json email_address"
  exit 1
end

MountainParser.new(ARGV[0], ARGV[1], ARGV[2]).perform
