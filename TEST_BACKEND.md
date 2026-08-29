# Quick Test Script - Backend Verification

## For Windows PowerShell

Run this script to quickly verify your backend is working:

```powershell
# ==============================================
# AGARO BACKEND TEST SCRIPT
# ==============================================

Write-Host "🚀 Starting Agaro Backend Tests..." -ForegroundColor Green

# Test 1: Check if XAMPP services are running
Write-Host "`n[TEST 1] Checking XAMPP Services..." -ForegroundColor Cyan
$apache = Get-Process | Where-Object {$_.ProcessName -like "*apache*"}
$mysql = Get-Process | Where-Object {$_.ProcessName -like "*mysqld*"}

if ($apache) { Write-Host "✅ Apache is running" -ForegroundColor Green }
else { Write-Host "❌ Apache is NOT running. Start it in XAMPP Control Panel" -ForegroundColor Red }

if ($mysql) { Write-Host "✅ MySQL is running" -ForegroundColor Green }
else { Write-Host "❌ MySQL is NOT running. Start it in XAMPP Control Panel" -ForegroundColor Red }

# Test 2: Check if admin panel is accessible
Write-Host "`n[TEST 2] Checking Admin Panel Accessibility..." -ForegroundColor Cyan
try {
    $response = Invoke-WebRequest -Uri "http://localhost/agaro/php_export/admin_manage.php" -TimeoutSec 5 -ErrorAction Stop
    Write-Host "✅ Admin panel is accessible" -ForegroundColor Green
    Write-Host "   URL: http://localhost/agaro/php_export/admin_manage.php" -ForegroundColor Gray
} catch {
    Write-Host "❌ Admin panel is not accessible" -ForegroundColor Red
    Write-Host "   Error: $_" -ForegroundColor Gray
}

# Test 3: Check News API
Write-Host "`n[TEST 3] Testing News API (GET all)..." -ForegroundColor Cyan
try {
    $newsResponse = Invoke-WebRequest -Uri "http://localhost/agaro/php_export/api_news.php?action=all" -TimeoutSec 5 -ErrorAction Stop
    $newsData = $newsResponse.Content | ConvertFrom-Json
    
    if ($newsData.success) {
        Write-Host "✅ News API is working" -ForegroundColor Green
        Write-Host "   Articles found: $($newsData.data.Count)" -ForegroundColor Gray
        if ($newsData.data.Count -gt 0) {
            Write-Host "   First article: $($newsData.data[0].title_en)" -ForegroundColor Gray
        }
    } else {
        Write-Host "❌ News API returned error" -ForegroundColor Red
    }
} catch {
    Write-Host "❌ News API is not responding" -ForegroundColor Red
    Write-Host "   Error: $_" -ForegroundColor Gray
}

# Test 4: Check Events API
Write-Host "`n[TEST 4] Testing Events API (GET upcoming)..." -ForegroundColor Cyan
try {
    $eventsResponse = Invoke-WebRequest -Uri "http://localhost/agaro/php_export/api_events.php?action=upcoming&limit=3" -TimeoutSec 5 -ErrorAction Stop
    $eventsData = $eventsResponse.Content | ConvertFrom-Json
    
    if ($eventsData.success) {
        Write-Host "✅ Events API is working" -ForegroundColor Green
        Write-Host "   Events found: $($eventsData.data.Count)" -ForegroundColor Gray
        if ($eventsData.data.Count -gt 0) {
            Write-Host "   First event: $($eventsData.data[0].title_en) on $($eventsData.data[0].event_date)" -ForegroundColor Gray
        }
    } else {
        Write-Host "❌ Events API returned error" -ForegroundColor Red
    }
} catch {
    Write-Host "❌ Events API is not responding" -ForegroundColor Red
    Write-Host "   Error: $_" -ForegroundColor Gray
}

# Test 5: Check Latest News Endpoint
Write-Host "`n[TEST 5] Testing News API (GET latest)..." -ForegroundColor Cyan
try {
    $latestResponse = Invoke-WebRequest -Uri "http://localhost/agaro/php_export/api_news.php?action=latest&limit=2" -TimeoutSec 5 -ErrorAction Stop
    $latestData = $latestResponse.Content | ConvertFrom-Json
    
    if ($latestData.success) {
        Write-Host "✅ Latest News endpoint is working" -ForegroundColor Green
        Write-Host "   Latest news: $($latestData.data.Count) articles" -ForegroundColor Gray
    } else {
        Write-Host "❌ Latest News endpoint returned error" -ForegroundColor Red
    }
} catch {
    Write-Host "❌ Latest News endpoint is not responding" -ForegroundColor Red
}

# Summary
Write-Host "`n================================================" -ForegroundColor Cyan
Write-Host "TEST SUMMARY" -ForegroundColor Cyan
Write-Host "================================================" -ForegroundColor Cyan
Write-Host "`nNext Steps:" -ForegroundColor Green
Write-Host "1. If all tests passed ✅ your backend is ready!" -ForegroundColor Green
Write-Host "2. Access admin panel: http://localhost/agaro/php_export/admin_manage.php" -ForegroundColor Gray
Write-Host "3. Password: agaro2026admin" -ForegroundColor Gray
Write-Host "4. Go to Dashboard to see existing news and events" -ForegroundColor Gray
Write-Host "5. Try adding new news/events from the admin panel" -ForegroundColor Gray
Write-Host "`nIf tests failed ❌ check:" -ForegroundColor Yellow
Write-Host "- XAMPP Apache and MySQL are running" -ForegroundColor Yellow
Write-Host "- MySQL events table exists in phpMyAdmin" -ForegroundColor Yellow
Write-Host "- File paths are correct" -ForegroundColor Yellow

Write-Host "`n" -ForegroundColor Green
```

---

## How to Run the Script

1. **Save the script** as `test_backend.ps1` in your project root
2. **Open PowerShell** as Administrator
3. **Navigate to your project:**
   ```powershell
   cd d:\xampp\htdocs\agaro
   ```
4. **Run the script:**
   ```powershell
   Set-ExecutionPolicy -ExecutionPolicy Bypass -Scope Process -Force
   .\test_backend.ps1
   ```

---

## What the Script Checks

✅ Apache is running  
✅ MySQL is running  
✅ Admin panel is accessible  
✅ News API works  
✅ Events API works  
✅ Data is being returned  

---

## Output Example (Success)

```
🚀 Starting Agaro Backend Tests...

[TEST 1] Checking XAMPP Services...
✅ Apache is running
✅ MySQL is running

[TEST 2] Checking Admin Panel Accessibility...
✅ Admin panel is accessible
   URL: http://localhost/agaro/php_export/admin_manage.php

[TEST 3] Testing News API (GET all)...
✅ News API is working
   Articles found: 3
   First article: Agaro Urban Highway Upgrade Project Commences

[TEST 4] Testing Events API (GET upcoming)...
✅ Events API is working
   Events found: 3
   First event: Community Town Hall Meeting on 2026-06-25

[TEST 5] Testing News API (GET latest)...
✅ Latest News endpoint is working
   Latest news: 2 articles

================================================
TEST SUMMARY
================================================

Next Steps:
1. If all tests passed ✅ your backend is ready!
2. Access admin panel: http://localhost/agaro/php_export/admin_manage.php
3. Password: agaro2026admin
```

---

## Manual Testing Without Script

If you prefer manual testing, just open these URLs in your browser:

1. **Admin Panel:** `http://localhost/agaro/php_export/admin_manage.php`
2. **All News:** `http://localhost/agaro/php_export/api_news.php?action=all`
3. **All Events:** `http://localhost/agaro/php_export/api_events.php?action=all`
4. **Latest News:** `http://localhost/agaro/php_export/api_news.php?action=latest&limit=3`
5. **Upcoming Events:** `http://localhost/agaro/php_export/api_events.php?action=upcoming&limit=3`

All should return JSON with your data!
