# How to Run & Test the Backend System

## Prerequisites
✅ XAMPP installed and running (Apache + MySQL)
✅ Agaro project in `d:\xampp\htdocs\agaro\`

---

## STEP 1: Start XAMPP & Create Database

### 1a. Start XAMPP Services
1. Open XAMPP Control Panel
2. Click **Start** next to Apache
3. Click **Start** next to MySQL
4. Wait for both to show "Running"

### 1b. Create Database Tables
1. Open browser: `http://localhost/phpmyadmin`
2. Click **Databases** tab
3. Look for `agaro_municipal_db` (should already exist from config.php)
4. Click on `agaro_municipal_db` 
5. Click **SQL** tab
6. Copy the contents of `php_export/events_table.sql`
7. Paste into the SQL editor
8. Click **Go**

**Expected Result:** "Query successful" message

---

## STEP 2: Test Admin Panel

### 2a. Access Admin Panel
1. Open browser
2. Navigate to: `http://localhost/agaro/php_export/admin_manage.php`

### 2b. Login
- **Password:** `agaro2026admin`
- Click **Login**

### 2c. Test Dashboard Tab
You should see:
- ✅ "Recent News Articles" list (should show 2 pre-seeded articles)
- ✅ "Upcoming Events" list (should show 3 pre-seeded events)
- ✅ Delete buttons for each item

**Expected Output:**
```
Recent News Articles (2)
- Agaro Urban Highway Upgrade Project Commences [Infrastructure] [6/8/2026]
- New Coffee Processing Cooperative Union Launched [Agriculture] [6/5/2026]

Upcoming Events (3)
- Community Town Hall Meeting [Community] [6/25/2026 9:00 AM]
- Specialty Arabica Coffee Festival 2026 [Festival] [10/14/2026 8:30 AM]
- Agaro Municipal Youth Sports Championship [Sports] [6/30/2026 2:00 PM]
```

### 2d. Test Adding News
1. Click **➕ Add News** tab
2. Fill in the form:
   - **Category:** Infrastructure
   - **Publication Date:** 2026-07-05
   - **Image URL:** `https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=800&q=80`
   - **Title (English):** New Infrastructure Project Launched
   - **Title (Afan Oromo):** Proyekti Misooma Haaraa Jalqabame
   - **Title (Amharic):** አዲስ የመሠረተ ልማት ፕሮጀክት ተጀመረ
   - **Excerpt (English):** We are proud to announce a new infrastructure project
   - **Excerpt (Afan Oromo):** Proyekti misooma haaraa agarsiisuuf gammadna
   - **Excerpt (Amharic):** አዲስ ፕሮጀክት ለማስተዋወቅ ደስተኛ ነን
   - **Full Content:** (Same or longer text for all languages)
3. Click **📝 Publish Article**

**Expected:** Green success message "News article added successfully!"

### 2e. Verify in Dashboard
1. Click **📊 Dashboard** tab
2. Refresh page (F5)
3. You should see your new article at the top

### 2f. Test Adding Event
1. Click **➕ Add Event** tab
2. Fill in the form:
   - **Category:** Community
   - **Event Date:** 2026-07-15
   - **Event Time:** 10:00
   - **Image URL:** `https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=800&q=80`
   - **Title (English):** Community Cleanup Drive
   - **Title (Afan Oromo):** Socho'a Qulqullina Uummataa
   - **Title (Amharic):** የጂቅ ማጽዳት ስራ
   - **Description (English):** Join us for a community cleanup event
   - **Description (Afan Oromo):** Waliin socho'a qulqullina keessa hirmaannee
   - **Description (Amharic):** ለጂቅ ማጽዳት ጥረት ተሳትፉ
   - **Location (English):** Central Park, Agaro
   - **Location (Afan Oromo):** Paarkii Giddu-gala, Aggaaroo
   - **Location (Amharic):** ማዕከላዊ ፓርክ፣ አጋሮ
3. Click **🎉 Create Event**

**Expected:** Green success message "Event added successfully!"

---

## STEP 3: Test REST APIs (Using Postman or Browser)

### 3a. Get All News Articles
```
GET http://localhost/agaro/php_export/api_news.php?action=all
```

**Expected Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": "news-1",
      "category": "Infrastructure",
      "date": "2026-06-08",
      "image": "https://...",
      "title_en": "Agaro Urban Highway Upgrade Project Commences",
      "title_om": "Projektiin Kiriipii...",
      "title_am": "የአጋሮ ከተማ...",
      ...
    }
  ]
}
```

### 3b. Get Latest News (Limit 3)
```
GET http://localhost/agaro/php_export/api_news.php?action=latest&limit=3
```

### 3c. Get News by Category
```
GET http://localhost/agaro/php_export/api_news.php?action=category&category=Infrastructure&limit=5
```

### 3d. Get All Events
```
GET http://localhost/agaro/php_export/api_events.php?action=all
```

### 3e. Get Upcoming Events (Limit 3)
```
GET http://localhost/agaro/php_export/api_events.php?action=upcoming&limit=3
```

### 3f. Get Single Article
```
GET http://localhost/agaro/php_export/api_news.php?id=news-1
```

---

## STEP 4: Test with cURL (Command Line)

Open PowerShell and run:

### 4a. Test News API
```powershell
# Get all news
Invoke-WebRequest -Uri "http://localhost/agaro/php_export/api_news.php?action=all" | ConvertFrom-Json | ConvertTo-Json

# Get latest 3 news
Invoke-WebRequest -Uri "http://localhost/agaro/php_export/api_news.php?action=latest&limit=3" | ConvertFrom-Json | ConvertTo-Json
```

### 4b. Test Events API
```powershell
# Get all events
Invoke-WebRequest -Uri "http://localhost/agaro/php_export/api_events.php?action=all" | ConvertFrom-Json | ConvertTo-Json

# Get upcoming events
Invoke-WebRequest -Uri "http://localhost/agaro/php_export/api_events.php?action=upcoming&limit=3" | ConvertFrom-Json | ConvertTo-Json
```

---

## STEP 5: Test Creating Data via API (Advanced)

### 5a. Create News Article via API
```powershell
$newsData = @{
    category = "Business"
    date = "2026-07-05"
    image = "https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=800&q=80"
    title_en = "Test Article from API"
    title_om = "Barreeffama Qorannoo API"
    title_am = "ከ API የተነሳ ፅሑፍ"
    excerpt_en = "Testing the API creation endpoint"
    excerpt_om = "Qorannoo endpoints of API"
    excerpt_am = "የ API ፅሑፍ ፈተና"
    content_en = "This is full content for the article"
    content_om = "Kun qabiyyee guutuu barreeffamaa dha"
    content_am = "ይህ የሙሉ የአንቀጽ ይዘት ነው"
}

$json = $newsData | ConvertTo-Json

Invoke-WebRequest -Uri "http://localhost/agaro/php_export/api_news.php?action=create" `
    -Method POST `
    -Headers @{"Content-Type"="application/json"} `
    -Body $json `
    | ConvertFrom-Json | ConvertTo-Json
```

**Expected Response:**
```json
{
  "success": true,
  "message": "News article created",
  "id": "news-1656976234-abcd1234"
}
```

---

## STEP 6: Check Database Directly

### 6a. View News in phpMyAdmin
1. Go to `http://localhost/phpmyadmin`
2. Click `agaro_municipal_db`
3. Click `news` table
4. You should see all articles with all language versions

### 6b. View Events in phpMyAdmin
1. Go to `http://localhost/phpmyadmin`
2. Click `agaro_municipal_db`
3. Click `events` table
4. You should see all events with dates and times

---

## STEP 7: Connect to React Frontend

### 7a. Update HomeView.tsx
Edit `src/components/HomeView.tsx` to fetch from backend:

```typescript
import { newsService, eventsService } from '@/services/newsEventsService';

useEffect(() => {
  // Fetch real data from backend
  newsService.getLatest(2).then(data => {
    if (data.length > 0) {
      console.log('News from backend:', data);
      // Update your state here
    }
  });
  
  eventsService.getUpcoming(3).then(data => {
    if (data.length > 0) {
      console.log('Events from backend:', data);
      // Update your state here
    }
  });
}, []);
```

### 7b. Test in Browser Console
1. Go to `http://localhost/agaro/`
2. Open DevTools (F12)
3. Open Console tab
4. Type:
```javascript
// Fetch news
fetch('http://localhost/agaro/php_export/api_news.php?action=latest&limit=3')
  .then(r => r.json())
  .then(d => console.log('News:', d))

// Fetch events
fetch('http://localhost/agaro/php_export/api_events.php?action=upcoming&limit=3')
  .then(r => r.json())
  .then(d => console.log('Events:', d))
```

**Expected:** Data printed in console

---

## Troubleshooting

### ❌ "Database Connection Error"
**Solution:**
1. Check MySQL is running in XAMPP
2. Verify database credentials in `php_export/config.php`
3. Check `agaro_municipal_db` exists in phpMyAdmin

### ❌ "404 Not Found"
**Solution:**
1. Check file paths are correct
2. Verify file exists: `php_export/api_news.php`
3. Check Apache is running

### ❌ "CORS Error" (Frontend can't reach API)
**Solution:**
- APIs already have CORS headers enabled
- Make sure API URLs are correct
- Check browser console for exact error

### ❌ "No data returned"
**Solution:**
1. Verify events table was created: `http://localhost/phpmyadmin`
2. Check if seed data was inserted
3. Look for error messages in browser console

---

## Quick Testing Checklist

- [ ] XAMPP Apache running
- [ ] XAMPP MySQL running  
- [ ] Events table created in phpMyAdmin
- [ ] Admin panel accessible at `http://localhost/agaro/php_export/admin_manage.php`
- [ ] Can login with password `agaro2026admin`
- [ ] Dashboard shows seeded news (2) and events (3)
- [ ] Can add new news article
- [ ] Can add new event
- [ ] API returns data: `http://localhost/agaro/php_export/api_news.php?action=all`
- [ ] API returns events: `http://localhost/agaro/php_export/api_events.php?action=all`
- [ ] Browser console shows data when fetching

---

## Common Commands

### Check if MySQL is running
```powershell
Get-Process | Where-Object {$_.ProcessName -like "*mysql*"}
```

### Test connection to database
```powershell
# Open MySQL CLI from XAMPP
cd "C:\xampp\mysql\bin"
mysql -u root
# Type: SHOW DATABASES;
```

### View Apache error logs
```
C:\xampp\apache\logs\error.log
```

### View MySQL error logs
```
C:\xampp\mysql\data\
```

---

## Success!

If you can see the dashboard with news articles and events, your backend is working! 🎉
