<?php
// Set path to download zip file
$dl_url = 'http://pjlumber.com/dev/pjlumber1.zip';

// Check if everything's cool and groovy - create a link to download zip file
if (system('zip -r /var/www/vhosts/pjlumber.com/httpdocs/dev/pjlumber1.zip /var/www/vhosts/pjlumber.com/httpdocs'))
{
echo '<p>All zipped up!</p>';
echo '<a href="' . $dl_url . '">Download</a>';
} else {
echo '<p>Balls! Didn\'t work.</p>';
}

?>