## ClamAV Drutiny plugin
This Drutiny plugin is to be used to provide additional ClamAV based profiles and policies.

Note: There is a harmless EICAR text file in the testsuite which is used to check the scans. No need to remove this.

## Running the profile
`./vendor/bin/drutiny profile:run clamscan @none`

# Running the phpuunit testsuite
`vendor/bin/phpunit tests/src/ClamAVScan.php`
