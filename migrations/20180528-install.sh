#!/usr/bin/env bash

# $1 == WordPress cli

echo " ---> Install the french translation"
$1 language core install fr_FR
$1 language core activate fr_FR

echo " ---> Set the permalink structure"
$1 rewrite structure "/%postname%/" --hard
$1 rewrite flush --hard

echo " ---> Create the team roles"
$1 role create teamleader "Team leader"
$1 cap add teamleader publish_posts read level_0

$1 role create teamcontributor "Team contributor"
$1 cap list author | xargs $1 cap add teamcontributor

echo " ---> Activate the composer plugins"
$1 plugin activate wordpress-importer
$1 plugin activate hide-admin-bar
$1 plugin activate badgeos
$1 plugin activate advanced-custom-fields
$1 plugin activate wp-force-login
$1 plugin activate multiple-roles

echo " ---> Activate the Succes plugins"
$1 plugin activate succes-block-admin
$1 plugin activate succes-teams

echo " ---> Configure WordPress options"
$1 option update users_can_register 1
$1 option update default_role subscriber

echo " ---> Configure BadgeOS"
$1 option update credly_settings --format=json < 20180528-credly.json
$1 option update badgeos_settings --format=json < 20180528-badgeos.json

echo " ---> Clean plugins data"
$1 post delete --force $($1 post list --post_type='achievement-type' --format=ids)

echo " ---> Import data"
$1 import 20180528-data.xml --authors=skip
$1 import 20180528-acf.xml --authors=skip

echo " ---> Set the front page"
id=$($1 post list --post_type=page --fields=ID,post_title | grep Succès)
id=$(echo $id | head -n1 | awk '{print $1;}')
$1 option update show_on_front page
$1 option update page_on_front $id

# id=$($1 post list --post_type=page --fields=ID,post_title | grep Groups)
# id=$(echo $id | head -n1 | awk '{print $1;}')
# $1 post delete $id --force

# id=$($1 post list --post_type=page --fields=ID,post_title | grep Members)
# id=$(echo $id | head -n1 | awk '{print $1;}')
# $1 post delete $id --force

echo " ---> Assign the top menu"
$1 menu location assign top-menu top

echo " ---> Activate the theme"
$1 theme activate succes

echo " ---> Remove the root user own"
chown www-data:www-data -R /var/www/html/wp-content/
