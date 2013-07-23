RewriteEngine On

# Don't rewrite bootstrap.php/ URLs or there would be an infinite rewrite loop!
RewriteCond %{REQUEST_FILENAME} !bootstrap.php.*
RewriteRule .* bootstrap.php/$0 [PT]
