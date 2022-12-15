 jQuery(document).ready(function($) {
      var videobackground = new $.backgroundVideo($('#front-page-1'), {
        "align": "centerXY",
        "width": 1280,
        "height": 720,
        "path": "/wp-content/themes/altitude-pro/media/",
        "filename": "beach",
        "types": ["mp4","ogv","webm"]
      });
    });