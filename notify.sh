while true; do
    begin=`date +%s`
    /opt/cpanel/ea-php56/root/usr/bin/php /home/stcp/public_html/artisan users:notify
    end=`date +%s`
    if [ $(($end - $begin)) -lt 1 ]; then
        sleep $(($begin + 1 - $end))
    fi
done
