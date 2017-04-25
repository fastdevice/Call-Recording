# Call-Recording
2600hz Call Recording

index.php assumes that a directory structure exists and index.php is installed in the "kzr" directory. 

for each "start recodring," update and insert this url:

i.e. \
(main call flow) http://<yourwebhost.com>/2125551212/kzr/index.php?recording=inbound/
(Start of each extension) http://<yourwebhost.com>/2125551212/kzr/index.php?recording=1001/
(no_match, before global carrier) http://<yourwebhost.com>/2125551212/kzr/index.php?recording=1001/

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
