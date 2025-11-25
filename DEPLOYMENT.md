# Deployment Guide - Blood Management System

This guide will help you deploy the Blood Management System to Render.com (free hosting).

## Prerequisites

1. A GitHub account with this repository
2. A Render.com account (free tier available)
3. Your repository pushed to GitHub

## Step-by-Step Deployment on Render.com

### 1. Create a Render.com Account

1. Go to [https://render.com](https://render.com)
2. Sign up for a free account (you can use GitHub to sign in)

### 2. Create a PostgreSQL Database

1. In Render dashboard, click **"New +"** → **"PostgreSQL"**
2. Configure:
   - **Name**: `bms-database` (or any name you prefer)
   - **Database**: `bms`
   - **User**: `bms_user`
   - **Region**: Choose closest to you
   - **Plan**: Free
3. Click **"Create Database"**
4. **Important**: Copy the **Internal Database URL** (you'll need this later)

### 3. Deploy the Web Service

**IMPORTANT**: Render doesn't have native PHP support. This project uses **Docker** for deployment.

#### Option A: Using render.yaml (Recommended)

1. In Render dashboard, click **"New +"** → **"Blueprint"**
2. Connect your GitHub repository: `OFENI/bms`
3. Render will automatically detect and use `render.yaml`
4. Review the configuration and click **"Apply"**

#### Option B: Manual Configuration (Docker)

1. In Render dashboard, click **"New +"** → **"Web Service"**
2. Connect your GitHub repository:
   - Click **"Connect GitHub"** if not already connected
   - Select the repository: `OFENI/bms`
   - Click **"Connect"**
3. Configure the service:
   - **Name**: `bms-web` (or any name)
   - **Region**: Same as database
   - **Branch**: `main`
   - **Root Directory**: Leave empty
   - **Environment**: **Docker**
   - **Dockerfile Path**: `./Dockerfile`
   - **Docker Context**: `.` (current directory)
   - **Plan**: Free
   - **Auto-Deploy**: Yes (optional)

### 4. Configure Environment Variables

In your Web Service settings, go to **"Environment"** and add these variables:

#### Required Variables:
```
APP_NAME=Blood Management System
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.onrender.com
APP_KEY= (will be generated automatically)

DB_CONNECTION=pgsql
DB_HOST= (from your PostgreSQL database - Internal Database URL)
DB_PORT=5432
DB_DATABASE=bms
DB_USERNAME=bms_user
DB_PASSWORD= (from your PostgreSQL database)
DB_URL= (use the Internal Database URL from PostgreSQL)

LOG_CHANNEL=stderr
LOG_LEVEL=error

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

#### How to get Database credentials:
1. Go to your PostgreSQL database in Render
2. Copy the **Internal Database URL** (format: `postgresql://user:password@host:port/database`)
3. Parse it to get individual values, OR use the `DB_URL` directly

**Option 1: Use DB_URL (Recommended)**
```
DB_URL=postgresql://user:password@host:port/database
DB_CONNECTION=pgsql
```

**Option 2: Individual values**
Extract from the Internal Database URL:
- `DB_HOST`: The hostname
- `DB_PORT`: Usually 5432
- `DB_DATABASE`: The database name
- `DB_USERNAME`: The username
- `DB_PASSWORD`: The password

### 5. Add Database Migration

After deployment, you need to run migrations. You can do this in two ways:

**Option A: Add to Build Command (Recommended)**
Update your build command to:
```bash
composer install --no-dev --optimize-autoloader && npm ci && npm run build && php artisan key:generate --force && php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

**Option B: Run via Render Shell**
1. Go to your Web Service
2. Click **"Shell"** tab
3. Run: `php artisan migrate --force`

### 6. Seed Initial Data (Optional)

If you have seeders, run them via Shell:
```bash
php artisan db:seed
```

### 7. Deploy

1. Click **"Create Web Service"**
2. Render will start building and deploying your application
3. Wait for the build to complete (usually 5-10 minutes)
4. Your app will be available at: `https://your-app-name.onrender.com`

## Post-Deployment Steps

### 1. Create Admin User

You'll need to create an admin user. You can do this via Render Shell:

```bash
php artisan tinker
```

Then in tinker:
```php
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@example.com';
$user->password = Hash::make('your-password');
$user->role = 'admin';
$user->save();
```

### 2. Configure Storage

If you need file storage, you may need to:
1. Create a storage link: `php artisan storage:link`
2. Configure filesystem in `.env` if needed

### 3. Set Up Custom Domain (Optional)

1. Go to your Web Service settings
2. Click **"Custom Domains"**
3. Add your domain and follow DNS instructions

## Troubleshooting

### Build Fails - Docker Issues
- Ensure `Dockerfile` exists in the root directory
- Check that Docker build is selected (not Node.js or other runtime)
- Verify Dockerfile syntax is correct
- Check build logs for specific Docker errors

### Build Fails - Other Issues
- Check build logs in Render dashboard
- Ensure all dependencies are in `composer.json` and `package.json`
- Verify PHP version compatibility (Laravel 12 requires PHP 8.2+)
- Make sure Runtime is set to **PHP**, not Node.js

### Database Connection Errors
- Verify `DB_URL` or individual database credentials
- Ensure database is in the same region as web service
- Check that database is running

### Application Errors
- Check application logs in Render dashboard
- Verify all environment variables are set correctly
- Ensure migrations have been run

### 500 Errors
- Check `APP_DEBUG=true` temporarily to see errors
- Verify `APP_KEY` is set
- Check file permissions (Render handles this automatically)

## Alternative Free Hosting Options

### Railway.app
- Similar to Render
- Free tier with $5 credit monthly
- Good for Laravel applications

### Fly.io
- Free tier available
- Good for containerized applications
- Requires Dockerfile

### Heroku
- Limited free tier
- Requires credit card for verification
- Good documentation

## Support

For issues specific to:
- **Render.com**: Check [Render Documentation](https://render.com/docs)
- **Laravel**: Check [Laravel Documentation](https://laravel.com/docs)
- **This Application**: Check the main README.md

## Notes

- Free tier on Render may spin down after 15 minutes of inactivity
- First request after spin-down may take 30-60 seconds
- Consider upgrading to paid plan for production use
- Database backups are recommended for production

