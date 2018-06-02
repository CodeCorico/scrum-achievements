FROM wordpress:4.9.6-php7.2

# Install needed programs
RUN apt-get update; \
	apt-get install -y --no-install-recommends mysql-client openssh-client git unzip

# Clean unused plugins & themes
RUN rm -Rf /usr/src/wordpress/wp-content/plugins/akismet && \
  rm -f /usr/src/wordpress/wp-content/plugins/hello.php && \
  rm -Rf /usr/src/wordpress/wp-content/themes/twentyfifteen && \
  rm -Rf /usr/src/wordpress/wp-content/themes/twentysixteen && \
  rm -Rf /usr/src/wordpress/wp-content/themes/twentyseventeen

# Install the WordPress cli
RUN curl -L "https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar" > /usr/bin/wp && \
  chmod +x /usr/bin/wp

# Configure the wp-cli to be able to perform some commands (like update the .htaccess)
RUN cd ~ && mkdir .wp-cli && cd .wp-cli && printf "path: /var/www/html\napache_modules: \n  - mod_rewrite\n" >> config.yml

# Install dependencies (themes & plugins) via composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY composer.json /usr/src/wordpress/composer.json

ARG COMPOSER_ENV=prod
ARG GITLAB_TOKEN

RUN chown www-data:www-data /usr/src/wordpress/composer.json

# Replace the ${GITLAB_TOKEN} variable inside the composer.json file
# by the true variable
RUN if [ "$GITLAB_TOKEN" != "" ] ; then \
  sed -i 's/${GITLAB_TOKEN}/'"${GITLAB_TOKEN}"'/g' /usr/src/wordpress/composer.json ; fi

RUN if [ "$COMPOSER_ENV" = "prod" ] ; then composer_arg="--no-dev" ; else composer_arg="" ; fi && \
  cd /usr/src/wordpress/ && composer install --no-interaction -o --no-progress --prefer-dist $composer_arg

# Add the source wp-content folders (if any)
COPY wp-content /usr/src/wordpress/wp-content/

# Remove the root user own
RUN chown www-data:www-data -R /usr/src/wordpress

# If you did'nt have a hook, then you have
RUN sed -i '/exec "$@"/d' /usr/local/bin/docker-entrypoint.sh

# Add the entrypoint logics
COPY docker/uploads.ini /usr/local/etc/php/conf.d/uploads.ini
COPY docker/docker-wp-entrypoint.sh /usr/local/bin/docker-wp-entrypoint
COPY docker/wp-migrations.sh /init.d/wp-migrations.sh
COPY migrations /usr/src/wordpress/migrations

RUN chmod -R +x /usr/local/bin/ /init.d/ /usr/src/wordpress/migrations

# Use the new entrypoint
ENTRYPOINT ["docker-wp-entrypoint"]
CMD ["apache2-foreground"]
