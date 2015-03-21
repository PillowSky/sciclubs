#!/bin/bash
# copy files
rm -rf /tmp/scicompass/
cp . -r /tmp/scicompass/
cd /tmp/scicompass/

# compile
coffee --join static/js/admin.js --compile static/js/admin/app.coffee static/js/admin/controller.coffee static/js/admin/service.coffee
coffee --join static/js/script.js --compile static/js/app.coffee static/js/controller.coffee static/js/service.coffee static/js/filter.coffee
coffee --join static/js/ucenter.js --compile static/js/ucenter/app.coffee static/js/ucenter/controller.coffee static/js/ucenter/service.coffee

lessc -x static/css/style.less static/css/style.css
lessc -x static/css/login.less static/css/login.css
lessc -x static/css/admin.less static/css/admin.css
lessc -x static/css/ucenter.less static/css/ucenter.css
jade application/views/*.jade
jade application/views/mail/*.jade&
jade static/partial/*.jade
jade static/partial/admin/*.jade
jade static/partial/ucenter/*.jade

# compress
uglifyjs static/js/admin.js --mangle --compress --screw-ie8 -o static/js/admin.js
uglifyjs static/js/script.js --mangle --compress --screw-ie8 -o static/js/script.js
uglifyjs static/js/ucenter.js --mangle --compress --screw-ie8 -o static/js/ucenter.js

# clean up
rm -rf doc
find . -name "*.coffee" -exec rm -fv {} \;
find . -name "*.less" -exec rm -fv {} \;
find . -name "*.jade" -exec rm -fv {} \;
find . -name "*.md" -exec rm -fv {} \;
find . -name "*.json" -exec rm -fv {} \;
find . -name "*.sh" -exec rm -fv {} \;

#deploy
saecloud deploy
