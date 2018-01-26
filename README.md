# Generate private and public key.
$ mkdir -p certificates/ <br>
$ openssl genrsa -out certificates/private.pem -aes256 4096 <br>
$ openssl rsa -pubout -in certificates/private.pem -out certificates/public.pem <br>

# Configure class Security constants.
PATH_CERTIFICATE_PRIVATE = ""; <br>
PATH_CERTIFICATE_PUBLIC = ""; <br>
SSL_KEY_PASSPHRASE = ""; <br>
TTL = 0; // seconds <br>

# INCLUDE config .htaccess in your root directory
RewriteEngine On <br>
RewriteCond %{HTTP:Authorization} . <br>
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}] <br>

# Use the class Security same as the examples
examples/login.php <br>
examples/private_area.php <br>
