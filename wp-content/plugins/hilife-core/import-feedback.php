<?php

$weddings = array(
    array(
        "venue" => "the Bridge Inn, Walshford, North Yorkshire",
        "dj" => "Darren Baxter",
        "caption" => "The music was exactly what we wanted and Darren timed tracks and judged the mood perfectly - even catering to the eclectic requests of the very drunken die-hard guests at the end of the night after we had gone to bed, which we are so grateful for.",
    ),
    array(
        "venue" => "marquee at Villa Farm, Near York",
        "dj" => "Mark Hepworth",
        "caption" => "Just a quick note to say thank you for helping to make our wedding day as fab as it was. The music was great, and exactly what we were after!",
    ),
    array(
        "venue" => "the KP Club, Near York",
        "dj" => "",
        "caption" => "Thank you for organising the music for the wedding. DJing was amazing, especially the scratching for the breakdance routine. Dance floor was packed all night.",
    ),
    array(
        "venue" => "Halifax Golf Club, West Yorkshire",
        "dj" => "Charlie C",
        "caption" => "Charles went down a storm! He was fantastic! Prompt, personable, he played songs when people asked for them, he was excellent. Guests have all said he was brilliant and the dance floor was full all night!",
    ),
    array(
        "venue" => "Sandal Rugby Club, Wakefield",
        "dj" => "Mark Hepworth",
        "caption" => "We had a great day & it was topped off by your performance in the evening. I've always said I wanted to mosh & do a wall of death at my wedding & we managed both! You exceeded all expectations.",
    ),
    array(
        "venue" => "East Riddlesden Hall, Near Keighley, West Yorkshire",
        "dj" => "Mark Hepworth",
        "caption" => "We just want to say a massive thank you. You did a great job. I was panicking all night that people weren't dancing however the pictures suggest otherwise, and people were loving the tunes and the atmosphere and lots were up dancing having the time of their lives. So mahooooosive THANK YOU",
    ),
    array(
        "venue" => "Pendle Heritage Centre, Nr Colne, Lancashire",
        "dj" => "Darren Baxter",
        "caption" => "Thank so much for getting Darren Baxter to come & play for us. Some great tunes, all mixed to perfection. Even my dad was dancing to Rock The Casbah! Never seen him dance EVER!",
    ),
    array(
        "venue" => "Hebden Bridge Town Hall, West Yorkshire",
        "dj" => "Mark Hepworth",
        "caption" => "I just wanted to drop you a line and say a big thank you for all your hard work on our wedding day. The music was amazing - everyone said you was the best wedding DJ they had ever heard!",
    ),
    array(
        "venue" => "Springfield House Hotel, Preston, Lancashire",
        "dj" => "Mark Hepworth",
        "caption" => "Thanks again for DJing our wedding. You did a great job. You made our night. Expect a few enquiries from our friends in coming months!",
    ),
    array(
        "venue" => "the Pack Horse, Market Street, Hayfield, Derbyshire",
        "dj" => "Darren Baxter",
        "caption" => "I just wanted say a big thank you to yourself and Darren. To yourself for all of your help booking and organising and to Darren for doing a fantastic job on the night. It couldn't have gone better and I would recommend Hi-Life Entertainment to anybody.",
    ),
    array(
        "venue" => "Waterside Hotel, Didsbury, Manchester",
        "dj" => "",
        "caption" => "Hi Mark, well it's done now! Thank you so much for supplying the DJ, he was wonderful and think he quite enjoyed the evening himself.",
    ),
    array(
        "venue" => "Barnsley Rugby Club, South Yorkshire",
        "dj" => "Mark Hepworth",
        "caption" => "Thanks again for last night Mark you properly rocked it, as I knew you would!! the music you played was awesome. hope to see you soon!",
    ),
    array(
        "venue" => "East Keswick Village Hall, North Yorkshire",
        "dj" => "",
        "caption" => "Mark, just wanted to say thank you for a great DJ. He got it just right and the dance floor was full from the first song he played! Everyone commented on how good the DJ was.",
    ),
    array(
        "venue" => "the Place, Manchester",
        "dj" => "Mark Hepworth",
        "caption" => "Just a quick note to say thank you for making our evening do the best wedding disco ever! We've had nothing but great feedback and it was so much fun. I would recommend your company to anyone in need of a DJ.",
    ),
    array(
        "venue" => "the Deansgate, Manchester",
        "dj" => "Mark Hepworth",
        "caption" => "People still talk about how great our wedding party was and it completely down to you. Thank you so much for playing for us.",
    ),
    array(
        "venue" => "the Roast, Leeds",
        "dj" => "",
        "caption" => "All I can say is wow! Last night was amazing for both Russ and I and all our guests; everyone has commented on how amazing DJ was and how different his set was from your normal wedding DJ. The service you offer is second to none, completely stress free and whatever you are doing works like magic.",
    ),
    array(
        "venue" => "Whalton Village Hall, Near Morpeth / Newcastle, Northumberland",
        "dj" => "Mark Hepworth",
        "caption" => "It was clear that you completely understood what style of music we were after from early evening through to the very last song. It was brilliant to see the dance floor busy all night long, that's exactly what we had hoped for! It was BRILLIANT!!",
    ),
);

// Clear existing feedback
$existing = get_posts(['post_type' => 'feedback', 'posts_per_page' => -1, 'fields' => 'ids']);
foreach ($existing as $id) {
    wp_delete_post($id, true);
}
echo "Cleared existing feedback\n";

foreach ( $weddings as $item ) {
    $post_id = wp_insert_post([
        'post_title'   => $item['venue'],
        'post_content' => $item['caption'],
        'post_type'    => 'feedback',
        'post_status'  => 'publish',
    ]);

    if ( $post_id && ! is_wp_error( $post_id ) ) {
        if ( ! empty( $item['dj'] ) ) {
            update_field( 'dj_name', $item['dj'], $post_id );
        }
        echo "Created: " . $item['venue'] . "\n";
    } else {
        echo "Failed: " . $item['venue'] . "\n";
    }
}

echo "Done!\n";