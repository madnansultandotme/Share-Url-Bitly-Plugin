<?php

global $post_id;

$bitly_url = get_su_bitly_short_url($post_id);

?>

<div class="su-social-share-buttons-wrapper">
    <p>Share Now</p>
    <div class="su-social-share-buttons">
        <div class="su-share-button su-facebook">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $bitly_url; ?>"
               target="_blank" rel="noopener noreferrer" title="Share on Facebook">
                <svg aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="dashicon dashicons-facebook-alt">
                    <path d="M8.46 18h2.93v-7.3h2.45l.37-2.84h-2.82V6.04c0-.82.23-1.38 1.41-1.38h1.51V2.11c-.26-.03-1.15-.11-2.19-.11-2.18 0-3.66 1.33-3.66 3.76v2.1H6v2.84h2.46V18z"></path>
                </svg>
            </a>
        </div>
        <div class="su-share-button su-twitter">
            <a href="https://twitter.com/share?url=<?php echo $bitly_url; ?>&text=<?php echo get_the_title($post_id); ?>"
               target="_blank" rel="noopener noreferrer" title="Share on Twitter">
                <svg aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="dashicon dashicons-twitter">
                    <path d="M18.94 4.46c-.49.73-1.11 1.38-1.83 1.9.01.15.01.31.01.47 0 4.85-3.69 10.44-10.43 10.44-2.07 0-4-.61-5.63-1.65.29.03.58.05.88.05 1.72 0 3.3-.59 4.55-1.57-1.6-.03-2.95-1.09-3.42-2.55.22.04.45.07.69.07.33 0 .66-.05.96-.13-1.67-.34-2.94-1.82-2.94-3.6v-.04c.5.27 1.06.44 1.66.46-.98-.66-1.63-1.78-1.63-3.06 0-.67.18-1.3.5-1.84 1.81 2.22 4.51 3.68 7.56 3.83-.06-.27-.1-.55-.1-.84 0-2.02 1.65-3.66 3.67-3.66 1.06 0 2.01.44 2.68 1.16.83-.17 1.62-.47 2.33-.89-.28.85-.86 1.57-1.62 2.02.75-.08 1.45-.28 2.11-.57z"></path>
                </svg>
            </a>
        </div>
        <div class="su-share-button su-email">
            <a href="mailto:?subject=<?php echo get_the_title($post_id); ?>&body=<?php echo $bitly_url; ?>"
               target="_blank" rel="noopener noreferrer" title="Email now">
                <svg aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="dashicon dashicons-email">
                    <path d="M3.87 4h13.25C18.37 4 19 4.59 19 5.79v8.42c0 1.19-.63 1.79-1.88 1.79H3.87c-1.25 0-1.88-.6-1.88-1.79V5.79c0-1.2.63-1.79 1.88-1.79zm6.62 8.6l6.74-5.53c.24-.2.43-.66.13-1.07-.29-.41-.82-.42-1.17-.17l-5.7 3.86L4.8 5.83c-.35-.25-.88-.24-1.17.17-.3.41-.11.87.13 1.07z"></path>
                </svg>
            </a>
        </div>
    </div>
</div>
