rm -rf dist
npm run build
cp -rf dist/* ../
rm -rf dist