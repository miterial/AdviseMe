<?php

//------------------------------------------------------------------------------
// Configuration to get all data
//------------------------------------------------------------------------------

// Global Configuration
$cnf['apikey'] = '';
$cnf['lang'] = 'ru';
$cnf['timezone'] = 'Europe/Berlin';
$cnf['adult'] = false;
$cnf['debug'] = false;

// Data Return Configuration - Manipulate if you want to tune your results
$cnf['appender']['movie'] = array('genres', 'original_title', 'overview', 'poster_path', 'production_countries', 'release_date', 'production_companies',  'credits', 'title', 'video', 'status');
$cnf['appender']['person'] = array('movie_credits', 'tv_credits', 'combined_credits', 'external_ids', 'images', 'tagged_images', 'changes');
$cnf['appender']['company'] = array('movies');

?>