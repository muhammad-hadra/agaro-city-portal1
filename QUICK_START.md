# 🚀 QUICK START - Run Backend in 5 Minutes

## STEP 1: Start Services (30 seconds)
```
1. Open XAMPP Control Panel
2. Click "Start" on Apache
3. Click "Start" on MySQL
4. Wait for both to show "Running"
```

## STEP 2: Create Events Table (1 minute)
```
1. Go to: http://localhost/phpmyadmin
2. Click "Databases" → "agaro_municipal_db"
3. Click "SQL" tab
4. Copy from: php_export/events_table.sql
5. Paste it in SQL editor
6. Click "Go"
7. See: "Query successful" ✅
```

## STEP 3: Access Admin Panel (immediate)
```
🌐 URL: http://localhost/agaro/php_export/admin_manage.php
🔐 Password: agaro2026admin
✅ Click "Dashboard" tab
```

**You should see:**
- 2 News Articles
- 3 Events

---

## STEP 4: Test Adding Content (2 minutes)

### Add a News Article:
1. Click **"➕ Add News"** tab
2. Fill in these fields:
   - Category: **Infrastructure**
   - Date: **2026-07-05**
   - Title (English): **New Road Project**
   - Excerpt (English): **We are building new roads**
   - Content (English): **Full description of the project**
   - Do same for Title/Excerpt/Content Afan Oromo and Amharic (can be same)
3. Click **"📝 Publish Article"**
4. See: **Green success message** ✅

### Add an Event:
1. Click **"➕ Add Event"** tab
2. Fill in:
   - Category: **Community**
   - Event Date: **2026-07-15**
   - Time: **10:00**
   - Title (English): **Community Meeting**
   - Description (English): **Join us for a community meeting**
   - Location (English): **City Hall**
   - Do same for Afan Oromo and Amharic
3. Click **"🎉 Create Event"**
4. See: **Green success message** ✅

---

## STEP 5: Test APIs (1 minute)

Open a new browser tab and visit these URLs:

### Test News API
```
http://localhost/agaro/php_export/api_news.php?action=all
```
Should show JSON with all news articles

### Test Events API
```
http://localhost/agaro/php_export/api_events.php?action=all
```
Should show JSON with all events

---

## ✅ VERIFICATION CHECKLIST

- [ ] XAMPP Apache running ✅
- [ ] XAMPP MySQL running ✅
- [ ] Events table created in phpMyAdmin ✅
- [ ] Admin panel loads: `http://localhost/agaro/php_export/admin_manage.php` ✅
- [ ] Can login with password `agaro2026admin` ✅
- [ ] Dashboard shows 2 news + 3 events ✅
- [ ] Can add new news article (green success) ✅
- [ ] Can add new event (green success) ✅
- [ ] API returns JSON data ✅

**If ALL checked → Backend is working! 🎉**

---

## 🔧 QUICK FIXES

### ❌ "Connection refused" or "Cannot connect"
```
→ Check Apache & MySQL are running in XAMPP
→ Check MySQL Service in Windows Services
```

### ❌ "404 Not Found"
```
→ Check path is correct: php_export/api_news.php
→ Check file exists in d:\xampp\htdocs\agaro\php_export\
```

### ❌ "No articles/events showing"
```
→ Check events_table.sql was imported in phpMyAdmin
→ Go to phpMyAdmin → agaro_municipal_db → events
→ Should see 3 rows (pre-seeded data)
```

### ❌ Admin panel shows blank/error
```
→ Check config.php has correct database credentials
→ Try: http://localhost/agaro/php_export/admin_manage.php?
→ Check browser console (F12) for errors
```

---

## 📚 FILES CREATED

| File | Purpose |
|------|---------|
| `api_news.php` | REST API for news CRUD |
| `api_events.php` | REST API for events CRUD |
| `admin_manage.php` | Web admin panel |
| `events_table.sql` | Create events table |
| `services/newsEventsService.ts` | React service client |

---

## 🌐 IMPORTANT URLs

| Purpose | URL |
|---------|-----|
| **Admin Panel** | `http://localhost/agaro/php_export/admin_manage.php` |
| **News API (all)** | `http://localhost/agaro/php_export/api_news.php?action=all` |
| **News API (latest)** | `http://localhost/agaro/php_export/api_news.php?action=latest&limit=3` |
| **Events API (all)** | `http://localhost/agaro/php_export/api_events.php?action=all` |
| **Events API (upcoming)** | `http://localhost/agaro/php_export/api_events.php?action=upcoming&limit=3` |
| **phpMyAdmin** | `http://localhost/phpmyadmin` |

---

## 🔐 PASSWORDS & CREDENTIALS

```
Admin Panel Password: agaro2026admin

⚠️ CHANGE THIS IN PRODUCTION!
→ Edit admin_manage.php line 22
→ Change 'agaro2026admin' to your own password
```

---

## 📝 NEXT STEPS

1. **Test the backend** using this guide ✅
2. **Connect React frontend** to APIs (see BACKEND_SETUP.md)
3. **Integrate with HomeView.tsx** to show real data
4. **Deploy to production** with proper security

---

## 💡 TIPS

- All content is **multilingual** (English, Afan Oromo, Amharic)
- **Images** are stored as URLs (no file upload needed)
- **Dates** use format: YYYY-MM-DD (2026-07-05)
- **Times** use format: HH:MM:SS (10:30:00)
- Data is **instantly available** via API after adding
- Admin panel is **instant** - no approval needed

---

## ❓ NEED HELP?

See detailed guides:
- **Full setup:** `HOW_TO_RUN_BACKEND.md`
- **API docs:** `BACKEND_SETUP.md`
- **Troubleshooting:** `HOW_TO_RUN_BACKEND.md` → Troubleshooting section

---

**Backend ready? Let's build! 🎯**
