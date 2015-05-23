<?php 

 //Import RSS feed 
        if(function_exists('fetch_feed')) {
          $feed = fetch_feed($rssfeedurl); // specify the source feed
          $limit = $feed->get_item_quantity($rsspostcount); // specify number of items
          $items = $feed->get_items(0, $limit); // create an array of rss items

        }

 //Loop and display RSS feed
        if ($limit == 0) echo '<div>The feed is either empty or unavailable.</div>';
        else foreach ($items as $item) : ?>

        <li class="rss-feed-listitem">
            <div class="rss-feed-article-link">
              <h3><a href="<?php echo $item->get_permalink(); ?>" title="<?php echo $item->get_date('j F Y @ g:i a'); ?>">
                <?php echo $item->get_title(); ?>
              </a></h3>
            </div>
        
            <div class="rss-feed-article-desc">
              <?php echo substr($item->get_description(), 0, 400); ?> 
            </div>
        </li>

 <?php endforeach; ?>