FROM httpd:2.4
RUN sed -i -e 's/^#\(LoadModule rewrite_module\)/\1/' -e 's/AllowOverride None/AllowOverride All/' conf/httpd.conf
COPY .htaccess htdocs/
