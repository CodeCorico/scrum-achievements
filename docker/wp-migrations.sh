#!/usr/bin/env bash

WP="wp --allow-root --no-color"

hooks() {
	if [ -d /var/www/html/hooks/$1 ]; then
		for f in /var/www/html/hooks/$1/*.sh; do
			fname=$(basename "$f" ".sh")
			fdir=$(dirname -- "$f")

  		echo " ---> Execute hook $1/$fname.sh"

			cd $fdir
			./$fname.sh "$WP"
		done
	fi
}

# Install WordPress if is not already installed
if ! $($WP core is-installed); then
	hooks "before-install"

  echo " ---> Install your website"
  $WP core install --url=$WEBSITE_URL --title="$WEBSITE_NAME" --admin_user=$WEBSITE_ADMIN_USER --admin_password=$WEBSITE_ADMIN_PASSWORD --admin_email=$WEBSITE_ADMIN_EMAIL --skip-email

	# Delete examples (with their comments)
	$WP post delete 1 --force
	$WP post delete 2 --force
	$WP post delete 3 --force

	# Remove the blog description example
	$WP option update blogdescription ''

	# Desactivate widgets
	$WP widget deactivate search-2 recent-posts-2 recent-comments-2 archives-2 categories-2 meta-2

	# Remove the root user own
	chown www-data:www-data -R /var/www/html

	hooks "after-install"
fi

hooks "before-migrations"

echo " ---> Execute migrations"

# Execute all migrations scripts
if [ -d /var/www/html/migrations ]; then
	for f in /var/www/html/migrations/*.sh; do
		fname=$(basename "$f" ".sh")
		fdir=$(dirname -- "$f")
		moption=$($WP option list --search="m-$fname" --field=option_value)

		if [ "$moption" = "" ]; then
			echo " ---> Execute $fname migration"

			cd $fdir
			./$fname.sh "$WP"

			$WP option add "m-$fname" "true"
		fi
	done
fi

hooks "after-migrations"
