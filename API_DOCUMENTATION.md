# 📚 API Documentation - MediRemind

Base URL: `http://localhost:8000/api`

## 🔐 Authentication

All protected endpoints require a Bearer token in the Authorization header:
```
Authorization: Bearer {token}
```

### Register
**POST** `/register`

Create a new user account.

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "+20123456789",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response (201):**
```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "+20123456789"
  },
  "token": "1|abc123...",
  "subscription": {
    "plan": "free",
    "status": "active"
  }
}
```

### Login
**POST** `/login`

Authenticate user and get token.

**Request Body:**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response (200):**
```json
{
  "user": {...},
  "token": "2|xyz789...",
  "subscription": {...}
}
```

### Logout
**POST** `/logout` 🔒

Revoke current access token.

**Response (200):**
```json
{
  "message": "Logged out successfully"
}
```

### Get User
**GET** `/user` 🔒

Get current authenticated user.

**Response (200):**
```json
{
  "user": {...},
  "subscription": {...}
}
```

---

## 💊 Medicines

### List Medicines
**GET** `/medicines` 🔒

Get all medicines for authenticated user.

**Response (200):**
```json
[
  {
    "id": 1,
    "name": "Aspirin",
    "dosage": "500mg",
    "type": "pill",
    "frequency": "daily",
    "times": ["09:00", "21:00"],
    "start_date": "2025-01-01",
    "end_date": "2025-02-01",
    "stock": 60,
    "notes": "Take with food",
    "is_active": true,
    "doses": [...]
  }
]
```

### Create Medicine
**POST** `/medicines` 🔒

Add a new medicine.

**Request Body:**
```json
{
  "name": "Aspirin",
  "dosage": "500mg",
  "type": "pill",
  "frequency": "daily",
  "times": ["09:00", "21:00"],
  "start_date": "2025-01-01",
  "end_date": "2025-02-01",
  "stock": 60,
  "notes": "Take with food"
}
```

**Response (201):**
```json
{
  "id": 1,
  "name": "Aspirin",
  ...
}
```

### Get Medicine
**GET** `/medicines/{id}` 🔒

Get specific medicine details.

### Update Medicine
**PUT** `/medicines/{id}` 🔒

Update medicine information.

### Delete Medicine
**DELETE** `/medicines/{id}` 🔒

Delete a medicine and all its doses.

---

## 💉 Doses

### List Doses
**GET** `/doses` 🔒

Get all doses with optional filters.

**Query Parameters:**
- `status` - Filter by status (pending, taken, missed, skipped)
- `from` - Start date (YYYY-MM-DD)
- `to` - End date (YYYY-MM-DD)

**Response (200):**
```json
[
  {
    "id": 1,
    "medicine_id": 1,
    "scheduled_time": "2025-12-19 09:00:00",
    "taken_time": null,
    "status": "pending",
    "notes": null,
    "medicine": {...}
  }
]
```

### Today's Doses
**GET** `/doses/today` 🔒

Get all doses scheduled for today.

### Upcoming Doses
**GET** `/doses/upcoming` 🔒

Get next 10 upcoming pending doses.

### Dose Statistics
**GET** `/doses/stats` 🔒

Get adherence statistics.

**Response (200):**
```json
{
  "total": 100,
  "taken": 85,
  "missed": 10,
  "pending": 5,
  "adherence_rate": 85.0
}
```

### Mark as Taken
**POST** `/doses/{id}/taken` 🔒

Mark a dose as taken.

**Request Body:**
```json
{
  "notes": "Taken with breakfast"
}
```

### Mark as Missed
**POST** `/doses/{id}/missed` 🔒

Mark a dose as missed.

### Mark as Skipped
**POST** `/doses/{id}/skipped` 🔒

Mark a dose as skipped.

---

## 📊 Dashboard

### Get Dashboard Data
**GET** `/dashboard` 🔒

Get comprehensive dashboard statistics.

**Response (200):**
```json
{
  "today_doses": [...],
  "upcoming_doses": [...],
  "active_medicines": 5,
  "adherence_rate": 87.5,
  "weekly_stats": [
    {
      "date": "2025-12-13",
      "day": "Fri",
      "taken": 3,
      "total": 4,
      "rate": 75.0
    },
    ...
  ],
  "stats": {
    "total_doses_30_days": 120,
    "taken_doses_30_days": 105,
    "missed_doses_30_days": 15
  }
}
```

---

## 💳 Subscriptions

### Get Current Subscription
**GET** `/subscription` 🔒

Get user's current subscription.

**Response (200):**
```json
{
  "id": 1,
  "plan": "pro",
  "status": "active",
  "start_date": "2025-01-01 00:00:00",
  "end_date": "2025-02-01 00:00:00",
  "amount": "49.00",
  "features": {
    "max_medicines": -1,
    "push_notifications": true,
    "whatsapp_notifications": true,
    "sms_notifications": true,
    "dose_history": true,
    "reports": true,
    "support": "24/7"
  }
}
```

### Subscribe to Plan
**POST** `/subscription/subscribe` 🔒

Subscribe to a new plan.

**Request Body:**
```json
{
  "plan_type": "pro",
  "payment_id": "pay_abc123"
}
```

### Cancel Subscription
**POST** `/subscription/cancel` 🔒

Cancel current subscription.

---

## 📋 Plan Features

### Free Plan
- Max 3 medicines
- Push notifications
- Limited support

### Pro Plan ($49/month)
- Unlimited medicines
- WhatsApp & SMS notifications
- Complete dose history
- 24/7 support
- Monthly reports

### Family Plan ($99/month)
- Up to 5 accounts
- All Pro features
- Family dashboard
- Priority support

---

## ⚠️ Error Responses

### 401 Unauthorized
```json
{
  "message": "Unauthenticated."
}
```

### 403 Forbidden
```json
{
  "message": "This action is unauthorized."
}
```

### 422 Validation Error
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email field is required."]
  }
}
```

### 404 Not Found
```json
{
  "message": "Resource not found."
}
```

---

🔒 = Requires Authentication
