#!/usr/bin/env bash
set -euo pipefail

APP_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
BACKUP_DIR="${BACKUP_DIR:-$APP_DIR/backups}"
STAMP="$(date +%Y%m%d-%H%M%S)"

mkdir -p "$BACKUP_DIR"

DB_NAME="$(grep -E '^DB_NAME=' "$APP_DIR/.env" | cut -d= -f2- | tr -d '"')"
DB_USER="$(grep -E '^DB_USER=' "$APP_DIR/.env" | cut -d= -f2- | tr -d '"')"
DB_PASS="$(grep -E '^DB_PASS=' "$APP_DIR/.env" | cut -d= -f2- | tr -d '"')"

MYSQL_PWD="$DB_PASS" mysqldump -u "$DB_USER" "$DB_NAME" | gzip > "$BACKUP_DIR/db-$STAMP.sql.gz"
tar -czf "$BACKUP_DIR/uploads-$STAMP.tar.gz" -C "$APP_DIR/public" uploads
find "$BACKUP_DIR" -type f -mtime +14 -delete

echo "Backup selesai: $BACKUP_DIR"
