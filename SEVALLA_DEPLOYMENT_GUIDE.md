# TESSMS Deployment Guide — Sevalla (Step by Step)

> This guide walks you through deploying the **Tugawe Elementary School Management System (TESSMS)** on [Sevalla](https://sevalla.com/) — a PaaS platform by the team behind Kinsta.

---

## Step 0: Before You Start (Pre-Deployment Checklist)

Make sure these are done **on your local machine** before deploying:

- [ ] `npm run build` succeeds and `public/build/manifest.json` exists
- [ ] `php artisan migrate:status` shows no pending migrations
- [ ] No debug code left (`dd()`, `dump()`, `var_dump()` removed from `app/` and `resources/views/`)
- [ ] `.env.example` is up to date (no secrets hardcoded)
- [ ] Your code is pushed to a **GitHub repository** (Sevalla deploys from Git)
- [ ] Migration files exist in `database/migrations/` (you should have ~100+ files)

---

## Step 1: Push Your Code to GitHub

Sevalla deploys directly from Git. Make sure your latest code is on GitHub:

```bash
git add .
git commit -m "Prepare for Sevalla deployment"
git push origin main
```

> Make sure `.env`, `node_modules/`, `vendor/`, and `storage/logs/` are in your `.gitignore`. They should already be there if you used Laravel's default.

---

## Step 2: Create a Sevalla Account

1. Go to [https://sevalla.com](https://sevalla.com) and sign up
2. **Use GitHub to authenticate** — this lets Sevalla pull your repositories automatically
3. Sevalla gives you **$50 free credit** to start

---

## Step 3: Create a Database on Sevalla

Your app needs MySQL. Create it **before** the application:

1. In Sevalla dashboard → click **"Databases"**
2. Click **"Create Database"**
3. Choose **MySQL 8.0**
4. Pick a name (e.g., `tessms-db`)
5. Choose a server location close to your users (e.g., **Singapore / Tokyo** for Philippines)
6. Choose the **Hobby** plan ($5/month) to start
7. Click **Create**

After creation, Sevalla will show you:
- **Host** (e.g., `mysql-xxx.sevalla.com`)
- **Port** (usually `3306`)
- **Database name**
- **Username**
- **Password**

**Copy these values** — you'll need them in Step 5.

---

## Step 4: Create the Application on Sevalla

1. Go to **"Applications"** → click **"Create an app"**
2. Under repositories, **choose your GitHub repo** (`tessms` or whatever you named it)
3. Select the **branch** you want to deploy (usually `main`)
4. Check **"Automatic deployment on commit"** — so every `git push` auto-deploys
5. **Application name**: `tessms` (or your preferred name)
6. **Server location**: Choose the **same region as your database** for low latency
7. **Resources**: Choose **Hobby** ($5/month) to start. You can scale later.

> **Important**: Do NOT click "Create and Deploy" yet. Click just **"Create"** — you need to add environment variables first.

---

## Step 5: Add Environment Variables

Sevalla needs your `.env` values. Go to your app → **"Environment variables"**.

Copy-paste ALL of these at once into the text box. Sevalla will auto-parse them:

```env
APP_NAME="TugaweES SMS"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://your-app-name.sevalla.app

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=YOUR_SEVALLA_DB_HOST
DB_PORT=3306
DB_DATABASE=YOUR_SEVALLA_DB_NAME
DB_USERNAME=YOUR_SEVALLA_DB_USER
DB_PASSWORD=YOUR_SEVALLA_DB_PASSWORD

SESSION_DRIVER=database
SESSION_LIFETIME=480
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax

BROADCAST_CONNECTION=reverb

REVERB_APP_ID=
REVERB_APP_KEY=
REVERB_APP_SECRET=
REVERB_HOST=127.0.0.1
REVERB_PORT=8080
REVERB_SCHEME=http

FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="admin@your-domain.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"

VAPID_SUBJECT="mailto:admin@your-domain.com"
VAPID_PUBLIC_KEY=
VAPID_PRIVATE_KEY=
VAPID_PEM_FILE=

WEBPUSH_DB_TABLE=push_subscriptions
WEBPUSH_AUTOMATIC_PADDING=true
```

### Critical values to replace:

| Variable | What to put |
|----------|-------------|
| `APP_KEY` | Run `php artisan key:generate` locally, copy the output |
| `APP_URL` | Your Sevalla URL (e.g., `https://tessms.sevalla.app`) |
| `DB_HOST` | From Step 3 (Sevalla database host) |
| `DB_DATABASE` | From Step 3 |
| `DB_USERNAME` | From Step 3 |
| `DB_PASSWORD` | From Step 3 |
| `REVERB_APP_ID`, `REVERB_APP_KEY`, `REVERB_APP_SECRET` | Run `php artisan reverb:generate` locally |
| `VAPID_PUBLIC_KEY`, `VAPID_PRIVATE_KEY` | Run `php artisan webpush:vapid` locally |

Click **Save**.

---

## Step 6: Configure Build Settings

Your app uses **Vite** for asset building. Go to your app → **"Build settings"**:

1. **Build command**: leave as detected (Sevalla auto-detects Laravel)
2. If you need to customize, add this as the **build command**:
   ```bash
   npm install && npm run build
   ```
3. **Node version**: Use **20.x** (or whatever matches your local `node -v`)

Sevalla handles the rest — it runs `composer install` automatically for Laravel projects.

---

## Step 7: Deploy!

1. Go to **"Deployments"**
2. Click **"Deploy now"**
3. Wait 2–5 minutes while Sevalla:
   - Pulls your code from GitHub
   - Runs `composer install`
   - Runs `npm install && npm run build`
   - Caches Laravel config/routes/views automatically

4. Once the status shows **"Deployed"**, click **"Visit App"**

---

## Step 8: Post-Deployment Setup (Run These Commands)

After the first deployment, you need to run some Laravel setup commands. Sevalla provides a **web terminal**:

1. Go to your app → **"Terminal"**
2. Run these commands one by one:

```bash
# 1. Generate application key (if you haven't already)
php artisan key:generate

# 2. Run database migrations
php artisan migrate --force

# 3. Create storage symlink (for uploaded files)
php artisan storage:link

# 4. Cache Laravel for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Clear any old caches
php artisan cache:clear
```

### Run Migrations

Now that migrations are generated, you can create the database schema:

```bash
php artisan migrate --force
```

### Import Existing Data (Optional)

If you want to migrate your local data to Sevalla:

1. Export your local AMPPS database via phpMyAdmin as a `.sql` file
2. Upload it to Sevalla via the terminal or SFTP
3. Import it:
   ```bash
   mysql -h YOUR_DB_HOST -u YOUR_DB_USER -p YOUR_DB_NAME < your-dump.sql
   ```

---

## Step 9: Set Up the Queue Worker

Your app uses `QUEUE_CONNECTION=database` for background jobs (notifications, emails, exports).

Sevalla handles this via **background processes**:

1. Go to your app → **"Processes"** (or "Daemons")
2. Click **"Add process"**
3. Fill in:
   - **Name**: `queue-worker`
   - **Command**: `php artisan queue:work --sleep=3 --tries=3 --max-time=3600`
   - **Count**: `1` (increase if you have high traffic)
4. Click **Create**

Sevalla will keep this process running 24/7.

---

## Step 10: Set Up the Scheduler (Cron Jobs)

Laravel's task scheduler needs to run every minute:

1. Go to your app → **"Cron jobs"**
2. Click **"Add cron job"**
3. Set:
   - **Command**: `php artisan schedule:run`
   - **Frequency**: `* * * * *` (every minute)
4. Click **Create**

---

## Step 11: Fix Storage Permissions

Your app handles file uploads (profile photos, documents). Make sure the `storage` folder is writable:

In the Sevalla terminal, run:

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

Sevalla usually handles this, but run it just in case uploads fail.

---

## Step 12: Add a Custom Domain (Optional)

1. Buy a domain (e.g., from Namecheap, Cloudflare, or GoDaddy)
2. In Sevalla → your app → **"Domains"**
3. Click **"Add domain"**
4. Enter your domain (e.g., `tugawees.edu` or `sms.tugawees.edu`)
5. Sevalla will give you DNS records (A record / CNAME)
6. Go to your domain registrar → DNS settings → add the records Sevalla provided
7. Wait 5–30 minutes for DNS to propagate
8. Back in Sevalla → click **"Verify"**
9. Sevalla automatically provisions a **free SSL certificate** (Let's Encrypt)

### Update APP_URL

After adding your custom domain, update the environment variable:

1. Go to **"Environment variables"**
2. Change `APP_URL` to your custom domain (e.g., `https://sms.tugawees.edu`)
3. Click **Save**
4. Run: `php artisan config:cache` in the terminal

---

## Step 13: PWA-Specific Post-Deployment

Your app is a PWA with push notifications, service workers, and biometric auth. These require **HTTPS** (which Sevalla provides automatically).

### Update manifest.json

In the Sevalla terminal:

```bash
nano public/manifest.json
```

Update:
```json
{
  "start_url": "https://your-domain.com/dashboard",
  "scope": "https://your-domain.com/"
}
```

### Test PWA

1. Visit your live site in Chrome
2. Open DevTools → **Lighthouse**
3. Run a **PWA audit**
4. Check for any errors

---

## Step 14: Verify Everything Works

Test these critical features:

- [ ] Homepage loads: `https://your-domain.com`
- [ ] Admin login works
- [ ] Teacher login works
- [ ] Student registration / enrollment flow works
- [ ] File uploads work (profile photos, documents)
- [ ] PWA manifest loads: `https://your-domain.com/manifest.json`
- [ ] Service worker loads: `https://your-domain.com/sw.js`
- [ ] No errors in logs (check Sevalla's **"Logs"** tab)

---

## Troubleshooting

### 500 Internal Server Error

1. Check Sevalla **Logs** tab
2. Run in terminal:
   ```bash
   tail -f storage/logs/laravel.log
   ```
3. Common fix:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   chmod -R 775 storage bootstrap/cache
   ```

### Database Connection Failed

- Double-check `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` in environment variables
- Make sure the database and app are in the **same region**
- Run: `php artisan migrate:status` in the terminal

### CSS/JS Not Loading (404 on build assets)

1. Check that `npm run build` ran successfully (check deployment logs)
2. Run manually in terminal:
   ```bash
   npm install && npm run build
   ```
3. Clear caches:
   ```bash
   php artisan cache:clear
   php artisan view:clear
   ```

### File Uploads Not Working

```bash
php artisan storage:link
chmod -R 775 storage/app/public
```

### Queue Jobs Not Processing

1. Check that the queue worker process is running (Step 9)
2. Check `failed_jobs` table:
   ```bash
   php artisan queue:failed
   ```

---

## Quick Reference: Useful Sevalla Terminal Commands

```bash
# View Laravel logs in real-time
tail -f storage/logs/laravel.log

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Re-cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Check migration status
php artisan migrate:status

# Run migrations
php artisan migrate --force

# Check queue failed jobs
php artisan queue:failed

# Retry failed jobs
php artisan queue:retry all

# Maintenance mode ON
php artisan down

# Maintenance mode OFF
php artisan up

# Check storage link
ls -la public/storage
```

---

## Estimated Monthly Cost on Sevalla

| Service | Cost |
|---------|------|
| Application (Hobby) | ~$5/month |
| Database (Hobby) | ~$5/month |
| Domain | ~$10–20/year |
| **Total** | **~$10/month** |

> You can start with the $50 free credit. Scale up resources only when you need more traffic.

---

**Happy Deploying! 🚀**
