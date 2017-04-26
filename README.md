# Call-Recording
2600hz Call Recording

index.php assumes that a directory structure exists and index.php is installed in the "kzr" directory.

account \
account/kzr \
account/rec \
  account/rec/inbound \
  account/rec/outbound \
  account/rec/1001 \
  account/rec/1002 \
  account/rec/1003 \
  account/rec/1004 \
  account/rec/1005 \
  account/rec/1006 \
  account/rec/1007 \
  account/rec/1008 \
  account/rec/1009 


for each "start recording," update and insert this url:

i.e. \
account = 2125551212 \
(main call flow) http://<yourwebhost.com>/2125551212/kzr/index.php?callflow=inbound \
(Start of each extension) http://<yourwebhost.com>/2125551212/kzr/index.php?callflow=1001 \
(no_match, before global carrier) http://<yourwebhost.com>/2125551212/kzr/index.php?callflow=1001 


