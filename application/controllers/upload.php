<?php
    $youtube_email = "cupdaily@gmail.com"; // Change this to your youtube sign in email.
    $youtube_password = "lamanabie"; // Change this to your youtube sign in password.
    // Developer key: Get your key here: http://code.google.com/apis/youtube/dashboard/.
    $key = "AI39si7bTiDto_4FaHTerrUfOrn0viKqQKJt9zmCitXRnMZrPtIQaWHqvffzQ_nDT3u9RSVcH2nRJn5yeCS9E-c5lROvfgJUrw"; 
    //notasecret
    $source = 'http://dailycup.skeletopedia.sk/'; // A short string that identifies your application for logging purposes.
    $postdata = "Email=".$youtube_email."&Passwd=".$youtube_password."&service=youtube&source=" . $source;
    $curl = curl_init( "https://www.google.com/youtube/accounts/ClientLogin" );
    curl_setopt( $curl, CURLOPT_HEADER, "Content-Type:application/x-www-form-urlencoded" );
    curl_setopt( $curl, CURLOPT_POST, 1 );
    curl_setopt( $curl, CURLOPT_POSTFIELDS, $postdata );
    curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0 );
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 2 );
    $response = curl_exec( $curl );
    curl_close( $curl );

    list( $auth, $youtubeuser ) = explode( "\n", $response );
    list( $authlabel, $authvalue ) = array_map( "trim", explode( "=", $auth ) );
    $parts = explode( "=", $youtubeuser );
    // var_dump($parts);
    if($parts[0] != "")
    list( $youtubeuserlabel, $youtubeuservalue ) =  array_map( "trim", $parts );
     // var_dump( $youtubeuserlabel);
     // var_dump( $youtubeuservalue );

    $youtube_video_title = $video_title; // This is the uploading video title.
    $youtube_video_description = $video_description; // This is the uploading video description.   
    $youtube_video_keywords = "demo"; // This is the uploading video keywords.
    $youtube_video_category = "Film"; // This is the uploading video category. There are only certain categories that are accepted. See below 
    /* 
     * Accepted Categories:
     * 
        Film
        Autos
        Music
        Animals
        Sports
        Travel
        Shortmov
        Games
        Videblog
        People
        Comedy
        Entertainment
        News
        Howto
        Education
        Tech
        Nonprofit
        Movies
        Movies_anime_action
        Movies_action_adventure
        Movies_classics
        Movies_comedy
        Movies_documentary
        Moves_drama
        Movies_family
        Movies_foreign
        Movies_horror
        Movies_sci_fi_fantasy
        Movies_thriller
        Movies_shorts
        Shows
        Trailers
     */  

        $data = '<?xml version="1.0"?>
        <entry xmlns="http://www.w3.org/2005/Atom"
        xmlns:media="http://search.yahoo.com/mrss/"
        xmlns:yt="http://gdata.youtube.com/schemas/2007">
        <yt:accessControl action="list" permission="denied"/>
        <media:group>
        <media:title type="plain">' . stripslashes( $youtube_video_title ) . '</media:title>
        <media:description type="plain">' . stripslashes( $youtube_video_description ) . '</media:description>
        <media:category
        scheme="http://gdata.youtube.com/schemas/2007/categories.cat">'.$youtube_video_category.'</media:category>
        <media:keywords>'.$youtube_video_keywords.'</media:keywords> 
    </media:group>
</entry>';

$headers = array( "Authorization: GoogleLogin auth=".$authvalue,
   "GData-Version: 2",
   "X-GData-Key: key=".$key,
   "Content-length: ".strlen( $data ),
   "Content-Type: application/atom+xml; charset=UTF-8" );

$curl = curl_init( "http://gdata.youtube.com/action/GetUploadToken");
curl_setopt( $curl, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"] );
curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $curl, CURLOPT_TIMEOUT, 10 );
curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $curl, CURLOPT_POST, 1 );
curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, 1 );
curl_setopt( $curl, CURLOPT_HTTPHEADER, $headers );
curl_setopt( $curl, CURLOPT_POSTFIELDS, $data );
curl_setopt( $curl, CURLOPT_REFERER, true );
curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, 1 );
curl_setopt( $curl, CURLOPT_HEADER, 0 );

$response = simplexml_load_string( curl_exec( $curl ) );
// print_r($response);
curl_close( $curl );

