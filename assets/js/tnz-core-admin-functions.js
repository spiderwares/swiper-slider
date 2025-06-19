jQuery(function($){
	
    class Tnz_admin_core {

        constructor(SS_modal){
            this.__this;
            this.SS_modal = SS_modal;

            this.slideshow_Sortable();
            this.eventHandlers();
        }

        eventHandlers(){
            $(document.body).on( 'click', 'a.tnz_upload_slide', this.upload_slideImage.bind(this) );
            $(document.body).on( 'click', 'a.tnz_slide_remove', this.remove_slideImage.bind(this) );
        }

        upload_slideImage(e) {
            e.preventDefault();
            this.__this	= $(e.currentTarget);
            var	_this = this,
                mediaUploader = wp.media({
                    title: 'Insert images',
                    library : {
                        type : 'image'
                    },
                    button: {
                        text: 'Use these images'
                    },
                    multiple: true
                }).on('select', function() {
                    var attachments = mediaUploader.state().get('selection').map(function(a) {
                        a.toJSON();
                        return a;
                    }),
                    i;

                    for ( i = 0; i < attachments.length; ++i) {
                        _this.SS_modal.append(
                            '<li><img width="250" src="' + attachments[i].attributes.sizes.tnz_slideshow_thumbnail.url + '"/><div class="tnz_slide_actions"><a href="#" class="tnz_slide_move"><span class="tooltip">Drag & Sort</span><i class="dashicons dashicons-move"></i></a><a href="#" class="tnz_slide_remove"><span class="tooltip">Delete</span> <i class="dashicons dashicons-trash"></i></a></div><input type="hidden" name="tnz_slideshow_image_ids[]" value="' + attachments[i].id + '" /></li>'
                        );
                    }  
                }).open();
        }

        remove_slideImage(e){
            e.preventDefault();
            this.__this	= $(e.currentTarget);
            this.__this.parents("li").remove();
        }

        slideshow_Sortable() {
            this.SS_modal.sortable({
                items:  'li',
                handle: '.tnz_slide_move',
                cursor: '-webkit-grabbing',
                stop:function(event,ui){
                    ui.item.removeAttr('style');
                }
            });
        }

    
    }
    new Tnz_admin_core( $('.tnz_ss_slides') );
});