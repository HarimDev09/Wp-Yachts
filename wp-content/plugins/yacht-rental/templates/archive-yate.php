// Create templates/archive-yate.php
<?php get_header(); ?>

<div class="gy-yacht-archive">
    <header class="page-header">
        <h1 class="page-title"><?php post_type_archive_title(); ?></h1>
    </header>
    
    <div class="gy-yacht-grid">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('gy-yacht-card'); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="gy-yacht-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="gy-yacht-content">
                        <h2 class="gy-yacht-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        
                        <div class="gy-yacht-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                        
                        <div class="gy-yacht-meta">
                            <?php
                            $model = get_post_meta(get_the_ID(), '_gy_model', true);
                            $year = get_post_meta(get_the_ID(), '_gy_year', true);
                            $max_people = get_post_meta(get_the_ID(), '_gy_max_people', true);
                            
                            if ($model) {
                                echo '<div class="gy-meta-item"><strong>' . __('Model', GY_TEXT_DOMAIN) . ':</strong> ' . esc_html($model) . '</div>';
                            }
                            
                            if ($year) {
                                echo '<div class="gy-meta-item"><strong>' . __('Year', GY_TEXT_DOMAIN) . ':</strong> ' . esc_html($year) . '</div>';
                            }
                            
                            if ($max_people) {
                                echo '<div class="gy-meta-item"><strong>' . __('Max People', GY_TEXT_DOMAIN) . ':</strong> ' . esc_html($max_people) . '</div>';
                            }
                            ?>
                        </div>
                        
                        <a href="<?php the_permalink(); ?>" class="gy-yacht-link">
                            <?php _e('View Details', GY_TEXT_DOMAIN); ?>
                        </a>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p><?php _e('No yachts found.', GY_TEXT_DOMAIN); ?></p>
        <?php endif; ?>
    </div>
    
    <?php the_posts_pagination(); ?>
</div>

<?php get_footer(); ?>