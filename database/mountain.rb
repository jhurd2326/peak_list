# frozen_string_literal: true

# == Schema Information
#
# Table name: mountains
#
#  id         :integer          not null, primary key
#  name       :string(255)
#  state      :string(255)
#  country    :string(255)
#  latitude   :string(255)
#  longitude  :string(255)
#  elevation  :integer
#

require "active_record"

class Mountain < ActiveRecord::Base
  def self.select_country(state)
    if us_states.include? state
      "United States of America"
    elsif candian_provinces.include? state
      "Canada"
    elsif russian_states.include? state
      "Russia"
    else
      "Mexico"
    end
  end

  def self.us_states
    %w(Alabama Alaska Arizona Arkansas California Colorado Connecticut Delaware Florida
       Georgia Hawaii Idaho Illinois Indiana Iowa Kansas Kentucky Louisiana Maine Maryland
       Massachusetts Michigan Minnesota Mississippi Missouri Montana Nebraska Nevada
       New\ Hampshire New\ Jersey New\ Mexico New\ York North\ Carolina North\ Dakota Ohio
       Oklahoma Oregon Pennsylvania Rhode\ Island South\ Carolina South\ Dakota Tennessee
       Texas Utah Vermont Virginia Washington West\ Virginia Wisconsin Wyoming
       District\ of\ Columbia Sonora)
  end

  def self.candian_provinces
    %w(Nova\ Scotia British\ Columbia Alberta Quebec Manitoba Ontario Yukon New\ Brunswick
       Newfoundland\ and\ Labrador Nunavut Saint\ Pierre\ and\ Miquelon)
  end

  def self.russian_states
    %w(Chukotka\ Autonomous\ Okrug)
  end
end
