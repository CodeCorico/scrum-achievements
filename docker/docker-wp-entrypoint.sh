#!/bin/sh
set -e

# Execute the original Wordpress entrypoint
/bin/bash docker-entrypoint.sh $@

# Execute all init scripts
if [ -d /init.d ]; then
	for f in /init.d/*.sh; do
		bash "$f"
	done
fi

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- apache2-foreground "$@"
fi

exec "$@"
