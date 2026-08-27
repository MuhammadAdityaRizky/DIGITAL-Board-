#!/bin/sh
set -e

PORT="${PORT:-8080}"
sed -i "s/listen 8080;/listen ${PORT};/g" /etc/nginx/http.d/default.conf

exec "$@"
