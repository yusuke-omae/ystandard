'use strict';jQuery(document).ready(function(a){var b,c='\u753B\u50CF\u3092\u9078\u629E',d='.ys-custom-image-upload-url',f='.ys-custom-image-upload-preview',g=100;a('.ys-custom-image-clear').click(function(){a(this).attr('data-uploaderurl')&&(d=a(this).attr('data-uploaderurl')),a(this).attr('data-uploaderpreview')&&(f=a(this).attr('data-uploaderpreview')),a(d).val(''),a(f).text('\u753B\u50CF\u304C\u9078\u629E\u3055\u308C\u3066\u307E\u305B\u3093\u3002'),a('.ys-custom-image-upload').css('display','block'),a('.ys-custom-image-clear').css('display','none')}),a('.ys-custom-image-upload').click(function(h){return h.preventDefault(),b?void b.open():void(a(this).attr('data-uploadertitle')&&(c=a(this).attr('data-uploadertitle')),a(this).attr('data-uploaderurl')&&(d=a(this).attr('data-uploaderurl')),a(this).attr('data-uploaderpreview')&&(f=a(this).attr('data-uploaderpreview')),a(this).attr('data-uploaderpreview-width')&&(g=a(this).attr('data-uploaderpreview-width')),b=wp.media({title:c,button:{text:'\u9078\u629E'},multiple:!1}),b.on('select',function(){var c=b.state().get('selection');c.each(function(b){var c=b.toJSON().url;a(d).val(c),a(f).text(''),a(f).append('<img style="max-width:'+g+'px;height:auto;" src="'+c+'" />'),a('.ys-custom-image-upload').css('display','none'),a('.ys-custom-image-clear').css('display','block')})}),b.open())})});