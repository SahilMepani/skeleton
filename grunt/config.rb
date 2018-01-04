# Set this to the root of your project when deployed:
http_path       = "/"
css_dir         = ""
sass_dir        = "sass"
images_dir      = "images"
javascripts_dir = "js"
output_style    = :compressed	# output_style = :expanded or :nested or :compact or :compressed
environment     = :production
line_comments   = false	# To disable debugging comments that display the original location of your selectors.
relative_assets = true	# To enable relative paths to assets via compass helper functions.
#sass_options   = { :debug_info => true } # Enable SourceMaps
require 'compass' # require gem compass
require 'breakpoint' # require gem breakpoint
require 'ceaser-easing' # require gem ceaser-easing