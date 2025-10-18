server{
    listen 80;
    listen [::]:80;
    server_name bookmyteacher www.bookmyteacher;
    root /var/www/bookmyteacher/public;
    index index.php index.html;
    location / {
         try_files $uri $uri/ /index.php$is_args$args;
    }
    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.1-fpm.sock;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    }
}
