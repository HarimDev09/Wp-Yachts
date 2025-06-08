jQuery(document).ready(function($) {
    // Hourly Pricing
    $('#gy-add-hour').on('click', function() {
        var index = $('#gy-hourly-pricing-container .gy-hourly-pricing-row').length;
        var template = $('#tmpl-gy-hourly-pricing-row').html();
        template = template.replace(/\{\{data\.index\}\}/g, index);
        $('#gy-hourly-pricing-container').append(template);
    });
    
    $(document).on('click', '.gy-remove-hour', function() {
        $(this).closest('.gy-hourly-pricing-row').remove();
    });
    
    // Key Features
    $('#gy-add-feature').on('click', function() {
        var title = $('#gy-new-feature-title').val();
        var desc = $('#gy-new-feature-desc').val();
        
        if (title) {
            var index = $('#gy-key-features-container .gy-key-feature-row').length;
            var template = $('#tmpl-gy-key-feature-row').html();
            template = template.replace(/\{\{data\.index\}\}/g, index)
                             .replace(/\{\{data\.title\}\}/g, title)
                             .replace(/\{\{data\.desc\}\}/g, desc);
            
            $('#gy-key-features-container').append(template);
            
            $('#gy-new-feature-title').val('');
            $('#gy-new-feature-desc').val('');
        }
    });
    
    $(document).on('click', '.gy-remove-feature', function() {
        $(this).closest('.gy-key-feature-row').remove();
    });
    
    // Gallery
    $('#gy-upload-gallery').on('click', function(e) {
        e.preventDefault();
        
        var frame = wp.media({
            title: gy_admin_vars.add_image,
            button: { text: gy_admin_vars.add_image },
            multiple: true
        });
        
        frame.on('select', function() {
            var attachments = frame.state().get('selection').toJSON();
            var gallery_ids = $('#gy_galeria').val();
            gallery_ids = gallery_ids ? gallery_ids.split(',') : [];
            
            $.each(attachments, function(i, attachment) {
                if ($.inArray(attachment.id.toString(), gallery_ids) === -1) {
                    gallery_ids.push(attachment.id);
                    
                    var html = '<li class="gy-gallery-image" data-attachment-id="' + attachment.id + '">';
                    html += '<img src="' + attachment.sizes.thumbnail.url + '" alt="">';
                    html += '<a href="#" class="gy-remove-image">×</a>';
                    html += '</li>';
                    
                    $('.gy-gallery-images').append(html);
                }
            });
            
            $('#gy_galeria').val(gallery_ids.join(','));
        });
        
        frame.open();
    });
    
    $(document).on('click', '.gy-remove-image', function(e) {
        e.preventDefault();
        
        var id = $(this).closest('.gy-gallery-image').data('attachment-id');
        var gallery_ids = $('#gy_galeria').val().split(',');
        
        gallery_ids = gallery_ids.filter(function(item) {
            return item != id;
        });
        
        $('#gy_galeria').val(gallery_ids.join(','));
        $(this).closest('.gy-gallery-image').remove();
    });
    
    // Sortable gallery
    $('.gy-gallery-images').sortable({
        update: function() {
            var ids = [];
            
            $('.gy-gallery-images .gy-gallery-image').each(function() {
                ids.push($(this).data('attachment-id'));
            });
            
            $('#gy_galeria').val(ids.join(','));
        }
    });
});