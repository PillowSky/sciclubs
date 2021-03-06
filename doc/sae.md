Patch and Config for CodeIgniter on SAE
===

1. Set up URL Rewrite
---
1. Edit application/config/config.php
```
$config['index_page'] = '';
```
2. Add rewrite handle in config.yaml
```
handle:
- rewrite: if (!-d && !-f) goto "/index.php/%{REQUEST_URI}"
```

2. Optimize config.yaml
---
1. Enforce https in admin panel
```
handle:
- rewrite: if (%{REQUEST_URI} ~ "^/admin" && %{REQ:X-Forwarded-Proto} != "https") goto "https://%{HTTP_HOST}%{REQUEST_URI}"
```
2. Deny privacy folder access
```
handle:
- rewrite: if (%{REQUEST_URI} ~ "^/system") goto "/index.php/%{REQUEST_URI}"
- rewrite: if (%{REQUEST_URI} ~ "^/application") goto "/index.php/%{REQUEST_URI}"
```
3. Compress text response
```
handle:
- compress:  if ( out_header["Content-type"] ~ "text/css" ) compress
- compress:  if ( out_header["Content-type"] ~ "text/javascript" ) compress
- compress:  if ( out_header["Content-type"] ~ "text/html" ) compress
- compress:  if ( out_header["Content-type"] ~ "text/plain" ) compress
- compress:  if ( out_header["Content-type"] ~ "application/json" ) compress
```
4. Direct static folder access
```
handlers:
- url: /static/
  static_path: static
```

3. Set up Database
---
1. Use `defined('SAE_APPNAME')` to detect environment
2. Config `$db['default']` and `$db['slave']` to Master / Slave database

4. Adapt Log class
---
1. Edit application/config/config.php (assume no MY_*.php in the directory)
```
$config['subclass_prefix'] = defined('SAE_APPNAME') ? 'SAE_' : 'MY_';
```
2. Extend Log.php to SAE_Log.php

5. Create Kvdb class
---
1. SAE
```
class Kvdb extends SaeKV {}
```
2. Others
```
class Kvdb extends Redis {}
```

6. Create Nsession class
---
1. CodeIgniter didn't use PHP native session, and its session class failed because SAE disabled local IO.
2. application/libraries/Nsession.php

7. Add set_json to CI_Output
---
1. system/core/Output.php is patched with one new function `set_json()`

8. Add json to CI_Input
---
1. system/core/Input.php is patched with one new function `json()`

9. Adapt create_captcha()
---
1. system/helpers/captcha_helper.php will use SAE native Vcode service if applicable

10. Adapt Mail class
---
1. system/libraries/Email.php will use SAE native Mail service if applicable

11. Patch Upload library
---
1. Bypass `is_dir()` check and add `saestor://` prefix on SAE in method `validate_upload_path()`
