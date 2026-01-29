# Deployment Guide - Los Pawlos Hermanos

This guide outlines the steps to deploy the **Los Pawlos Hermanos** Laravel application to a hosting provider (like Railway or Render).

## 1. Prepare for GitHub
Before deploying, you must push your code to your GitHub account (`https://github.com/Rimzy1227`).

### Commands to push to GitHub:
1. Open your terminal in the project folder.
2. Initialize Git:
   ```powershell
   git init
   git add .
   git commit -m "Initial commit for Los Pawlos"
   ```
3. Create a new **public** repository on GitHub named `Los-Pawlos`.
4. Link and push (replace `Rimzy1227` with your username if different):
   ```powershell
   git branch -M main
   git remote add origin https://github.com/Rimzy1227/Los-Pawlos.git
   git push -u origin main
   ```

## 2. Hosting on Railway.app (Recommended)
Railway is excellent for Laravel because it handles MySQL and HTTPS automatically.

### Steps:
1. **Connect GitHub**: Log in to [Railway.app](https://railway.app/) and click **"New Project" > "Deploy from GitHub repo"**.
2. **Select Repo**: Choose your `Los-Pawlos` repository.
3. **Add MySQL**: Click **"New" > "Database" > "Add MySQL"**. Railway will create a database for you.
4. **Environment Variables**: Go to the **"Variables"** tab for your app and add these from your `.env`:
   - `APP_KEY`: (Run `php artisan key:generate --show` to get it)
   - `APP_ENV`: `production`
   - `APP_DEBUG`: `false`
   - `APP_URL`: Your Railway URL (e.g., `https://los-pawlos.up.railway.app`)
   - `DB_CONNECTION`: `mysql`
   - `DB_HOST`: `${{MySQL.MYSQL_HOST}}` (Railway uses these variables)
   - `DB_PORT`: `${{MySQL.MYSQL_PORT}}`
   - `DB_DATABASE`: `${{MySQL.MYSQL_DATABASE}}`
   - `DB_USERNAME`: `${{MySQL.MYSQL_USER}}`
   - `DB_PASSWORD`: `${{MySQL.MYSQL_PASSWORD}}`
   - `STRIPE_KEY`: (Your Stripe Public Key)
   - `STRIPE_SECRET`: (Your Stripe Secret Key)
   - `GOOGLE_CLIENT_ID`: (Your Google ID)
   - `GOOGLE_CLIENT_SECRET`: (Your Google Secret)
   - `GOOGLE_REDIRECT_URI`: `https://your-app-name.up.railway.app/auth/google/callback`

## 3. Post-Deployment Commands
Once Railway finishes building, you need to set up the database tables. Go to the **"View Logs"** or **"Console"** in Railway and run:
```bash
php artisan migrate --force
php artisan db:seed --force
```

## 4. Update Third-Party Settings
- **Google Cloud Console**: Update your **Authorized Redirect URIs** to include your live URL: `https://your-app-name.up.railway.app/auth/google/callback`.
- **Stripe Dashboard**: Make sure your **Success URL** in the code (or `.env` variables if you used them there) points to your live domain.

## 5. Rubric Verification (Marks)
- **HTTPS**: Railway provides this automatically (15 marks).
- **Environment Separation**: Using Railway variables instead of hardcoding keys (15 marks).
- **CI/CD**: Pushing to GitHub automatically triggers a new deployment (15 marks).
