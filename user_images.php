<?php 
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.


require('program_files/program_header.php');


// User Images is different to other pages as it can by ran by different places.

/*

By its own page  (user_images.php) as a standalone
As an include from within seasonal_articles

Additionally the page can also accept ajax requests so as to not reload headers


*/


include('root_includes/user_images.php');


require('program_files/program_footer.php');