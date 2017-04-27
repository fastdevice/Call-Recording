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

Front end (client facing public interface)

You may want to include .htaccess so the files will display correclty and be organized.
You may also want to include the following statments in your .htaccess file to secure it. Please google a howto 
on creating the .htpasswd file.

AuthType Basic \
AuthName "Restricted Access" \
AuthUserFile /account/rec/.htpasswd \
Require user username

For those looking for a slick GUI for the front end, I recommend FileRun. It's free for the first three users and then they charge per tier. However, I"m starting to look into the opensource project OwnCloud/ NextCloud. It appears to have many of the same features of FileRun and supports connectors to dropbox etc.  
