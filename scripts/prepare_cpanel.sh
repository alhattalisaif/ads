#!/usr/bin/env bash
set -e

# prepare_cpanel.sh
# Usage: run this script locally to build frontend and prepare a zip to upload to cPanel.

ROOT_DIR=$(cd "$(dirname "$0")/.." && pwd)
FRONTEND_DIR="$ROOT_DIR/frontend"
BACKEND_DIR="$ROOT_DIR/backend"
BUILD_DIR="$ROOT_DIR/cpanel_build"

echo "Preparing build for cPanel..."

rm -rf "$BUILD_DIR"
mkdir -p "$BUILD_DIR"

# Build frontend
if [ -d "$FRONTEND_DIR" ]; then
  echo "Building frontend..."
  cd "$FRONTEND_DIR"
  npm ci
  npm run build
  echo "Copying frontend dist to backend/public/spa..."
  mkdir -p "$BACKEND_DIR/public/spa"
  rm -rf "$BACKEND_DIR/public/spa/*"
  cp -R dist/* "$BACKEND_DIR/public/spa/"
fi

# Copy backend files
echo "Copying backend files..."
cp -R "$BACKEND_DIR" "$BUILD_DIR/"

# Remove dev files
echo "Cleaning node_modules and vendor from build..."
rm -rf "$BUILD_DIR/backend/node_modules" || true
rm -rf "$BUILD_DIR/backend/vendor" || true

# Create deploy zip
cd "$BUILD_DIR"
ZIP_NAME="ads-cpanel-deploy.zip"
zip -r "$ZIP_NAME" backend > /dev/null

echo "Build ready: $BUILD_DIR/$ZIP_NAME"

echo "Next steps: upload the zip contents to your cPanel File Manager, set document root to backend/public, run composer install, set .env values, set permissions for storage and bootstrap/cache, run php artisan migrate --force, and optionally set up cron for queues."
