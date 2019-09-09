cd /var/www/html/
rm -r js/ css/
cd /var/www/html/client/src
vue build
cd ../../
cp -rf dist/* .
rm -r dist