<?php 
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.


require('program_files/program_header.php');


 

// image_upload is different to other pages as it can by ran by different places.

/*

By its own page  (image_upload.php) as a standalone
As an include from within seasonal_articles

Because this form can accept posts from these other pages,  we need to use a root include so we don't attempt to load the program headers more than once.

Additionally the page can also accept ajax requests so as to not reload headers


*/

include('root_includes/image_upload.php');


require('program_files/program_footer.php');
