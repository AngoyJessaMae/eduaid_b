# 🚀 EduAid - Railway Deployment Guide

## Why Railway?
✅ Native Laravel support  
✅ Auto PHP environment detection  
✅ MySQL/PostgreSQL included  
✅ Git-based deployment (push to deploy)  
✅ Free tier available  
✅ Zero code changes needed  

---

## Step 1: Prepare Your Repository

### 1.1 Initialize Git (if not already done)
```bash
cd c:\xampp\htdocs\eduaid_b
git init
git add .
git commit -m "Initial commit - ready for Railway deployment"
```

### 1.2 Create a `.gitignore` (if missing)
Make sure these are ignored:
```
node_modules/
vendor/
.env
.env.local
*.log
storage/
bootstrap/cache/
```

---

## Step 2: Set Up Railway Account

1. **Go to** https://railway.app
2. **Sign up** with GitHub (easiest)
3. **Authorize** Railway to access your GitHub account

---

## Step 3: Create Railway Project

1. Click **"+ New Project"** on Railway dashboard
2. Select **"Deploy from GitHub"**
3. Find & select your `eduaid_b` repository
4. Click **"Deploy Now"**

---

## Step 4: Configure Environment Variables

Railway will auto-detect this is a Laravel app. Now you need to configure:

### In Railway Dashboard:

1. Go to your project → **Variables** tab
2. Add these variables:

```
APP_NAME=EduAid
APP_ENV=production
APP_DEBUG=false
APP_KEY=                    # Keep empty - Railway will generate
APP_URL=${{ RAILWAY_ENVIRONMENT_NAME }}.up.railway.app

DB_CONNECTION=mysql
DB_HOST=${{ MYSQL_HOST }}
DB_PORT=${{ MYSQL_PORT }}
DB_DATABASE=${{ MYSQL_DB }}
DB_USERNAME=${{ MYSQL_USER }}
DB_PASSWORD=${{ MYSQL_PASSWORD }}

LOG_CHANNEL=stack
LOG_LEVEL=info

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database
SESSION_DRIVER=database
```

### Add MySQL Database:

1. In Railway, click **"+ Add Service"**
2. Select **MySQL**
3. Railway will automatically populate `MYSQL_HOST`, `MYSQL_PORT`, `MYSQL_DB`, `MYSQL_USER`, `MYSQL_PASSWORD`

---

## Step 5: First Deployment

1. **Generate APP_KEY:**
   - Railway automatically runs migrations with `--force` flag
   - The app will generate a key on first boot

2. **Wait for build** (2-5 minutes)
   - Railway builds the Docker image
   - Composer dependencies install
   - NPM builds assets

3. **Check Logs:**
   - Click project → **Deployments** tab
   - View logs to see if migrations ran successfully

---

## Step 6: Post-Deployment Steps

If you need to run commands on Railway:

1. Go to **Deployments** → Your active deployment
2. Click **"Open Plugin"** or use Railway CLI:

```bash
# Install Railway CLI
npm i -g @railway/cli

# Login
railway login

# Link your project
railway link

# Run artisan commands
railway run php artisan migrate
railway run php artisan db:seed
railway run php artisan cache:clear
```

---

## Step 7: Custom Domain (Optional)

1. In Railway, go to **Settings** → **Domain**
2. Add your custom domain (e.g., eduaid.com)
3. Update DNS records as shown in Railway
4. Update `APP_URL` environment variable

---

## Environment Variables Cheat Sheet

| Variable | Value |
|----------|-------|
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `DB_CONNECTION` | `mysql` |
| `FILESYSTEM_DISK` | `local` (or `s3` if using AWS S3) |
| `QUEUE_CONNECTION` | `database` |
| `LOG_LEVEL` | `info` |

---

## Troubleshooting

### "Application failed to start"
```bash
# Check logs in Railway dashboard
# Common issues:
# 1. APP_KEY not set - Railway auto-generates on first run
# 2. Database migrations failed - check MySQL connection
# 3. Composer/NPM build failed - check build logs
```

### "502 Bad Gateway"
```bash
# App crashed. Check:
railway logs
# Then redeploy:
git push origin main
```

### Database connection refused
```bash
# MySQL not running. In Railway:
# 1. Delete MySQL service
# 2. Add MySQL again
# 3. Redeploy your app
```

### Assets not loading (CSS/JS broken)
```bash
# Run in Railway:
railway run npm run build
```

---

## Deployment Commands

```bash
# Push to deploy (automatic)
git push origin main

# Rollback to previous version
# In Railway dashboard → Deployments → Select old version → Redeploy

# View logs
railway logs

# SSH into running container (if needed)
railway connect
```

---

## Cost Estimate
- **Free tier:** First $5/month credit  
- **Typical cost:** $10-20/month for small projects  
- **What's included:** 1 app + MySQL database + logs

---

## Next Steps

After successful deployment:
1. ✅ Test login at `your-app.up.railway.app`
2. ✅ Verify admin panel works
3. ✅ Test database operations (pretest, quizzes, etc.)
4. ✅ Check logs for errors
5. ✅ Set up monitoring alerts

---

## Quick Links
- [Railway Docs](https://docs.railway.app)
- [Laravel on Railway](https://docs.railway.app/guides/laravel)
- [Railway CLI Reference](https://docs.railway.app/reference/cli-api)

---

**Good luck! 🎉 Your EduAid app will be live in minutes!**
