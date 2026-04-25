#  HMAC Signature Based Authentication
### Group 7 | CS 252 – Web Systems and Technologies
**City College of Calamba | Department of Computing and Informatics**

---

##  What is HMAC Authentication?

**HMAC (Hash-based Message Authentication Code)** is a method of verifying the authenticity and integrity of API requests. Instead of sending a username and password on every request, the client generates a cryptographic signature using a shared secret key. The server then verifies the signature before allowing access.

---

##  Authentication Flow

```
Client                                        Laravel Server
  |                                                 |
  |  1. Prepare request data:                       |
  |     apiKey + timestamp + payload                |
  |                                                 |
  |  2. Generate signature:                         |
  |     HMAC-SHA256(message, secret_key)            |
  |                                                 |
  |  3. Send request with headers:                  |
  |     X-API-KEY: group7                           |
  |     X-TIMESTAMP: 1714000000         ──────────> |
  |     X-SIGNATURE: <hmac_hash>                    |
  |                                                 |
  |                              4. Check headers exist
  |                              5. Rebuild signature
  |                              6. Compare signatures
  |                                                 |
  |  <──── 200 OK (data) or 401 Unauthorized ────── |
```

---

##  Requirements

- PHP 8.2+
- Composer
- Laravel 11
- PostgreSQL
- XAMPP or any local server
- Postman (for testing)

---

##  Setup Instructions

### Step 1 — Clone the Repository

```bash
git clone https://github.com/maumaupangilinan-pixel/HMAC-Signature-Based-Authentication---Group-7.git
cd HMAC-Signature-Based-Authentication---Group-7
```

### Step 2 — Install Dependencies

```bash
composer install
```

### Step 3 — Create the `.env` File

Copy the example environment file:

```bash
cp .env.example .env
```

Then open `.env` and update the following:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=online_store_finals
DB_USERNAME=postgres
DB_PASSWORD=your_password

HMAC_SECRET=your_secret_key
```

### Step 4 — Generate App Key

```bash
php artisan key:generate
```

### Step 5 — Run Migrations and Seeders

```bash
php artisan migrate
php artisan db:seed
```

### Step 6 — Start the Server

```bash
php artisan serve
```

The API will be available at: `http://127.0.0.1:8000`

---

## 📡 API Endpoints

All endpoints require valid HMAC headers.

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/customers` | Get all customers |
| GET | `/api/items` | Get all items |
| POST | `/api/orders` | Create a new order |
| GET | `/api/analytics/orders-per-customer` | Orders per customer |
| GET | `/api/analytics/best-selling` | Best selling items |
| GET | `/api/analytics/total-sales` | Total sales |

---

##  Required Headers

Every request must include these headers:

| Header | Description | Example |
|--------|-------------|---------|
| `X-API-KEY` | Your API identifier | `group7` |
| `X-TIMESTAMP` | Unix timestamp | `1714000000` |
| `X-SIGNATURE` | HMAC-SHA256 signature | `94fc730d...` |
| `Content-Type` | Request content type | `application/json` |
| `Accept` | Expected response type | `application/json` |

---

##  Testing with Postman

### Step 1 — Set the URL and Method

```
GET http://127.0.0.1:8000/api/customers
```

### Step 2 — Add Headers

| Key | Value |
|-----|-------|
| `Accept` | `application/json` |
| `Content-Type` | `application/json` |

### Step 3 — Add Pre-request Script

In Postman, click the **Pre-request Script** tab and paste:

```javascript
const apiKey    = 'group7';
const timestamp = '1714000000';
const secret    = 'your_secret_key'; // must match HMAC_SECRET in .env
const payload   = pm.request.body.raw || '';

const message   = apiKey + timestamp + payload;
const signature = CryptoJS.HmacSHA256(message, secret).toString();

pm.request.headers.add({ key: 'X-API-KEY',   value: apiKey });
pm.request.headers.add({ key: 'X-TIMESTAMP', value: timestamp });
pm.request.headers.add({ key: 'X-SIGNATURE', value: signature });
```

### Step 4 — Send the Request

**Expected Responses:**

| Scenario | Response |
|----------|----------|
| ✅ Valid signature | `200 OK` + JSON data |
| ❌ Missing headers | `401 Unauthorized (Missing Headers)` |
| ❌ Wrong signature | `401 Unauthorized (Invalid Signature)` |

---

##  How the Signature is Generated

### Formula
```
message   = apiKey + timestamp + payload
signature = HMAC-SHA256(message, secret_key)
```

### Example (PHP)
```php
$message   = $apiKey . $timestamp . $payload;
$signature = hash_hmac('sha256', $message, $secret);
```

### Example (JavaScript - Postman)
```javascript
const message   = apiKey + timestamp + payload;
const signature = CryptoJS.HmacSHA256(message, secret).toString();
```

---

##  Advantages of HMAC

- No passwords sent over the network
- Request integrity — body tampering is detected
- Stateless — no sessions or tokens stored server-side
- Fast and lightweight

##  Disadvantages of HMAC

- Secret key must be kept safe — if it leaks, all security is lost
- No built-in expiration of signatures
- Client and server must use the exact same formula

---

##  Group 7 Members

| Name            | Role |
| Sean Pangilinan | Leader |


---

##  Authentication Passkey

const apiKey    = 'group7';
const timestamp = '1714000000';
const secret    = '852963';
const payload   = pm.request.body.raw || '';  // use actual body!

const message   = apiKey + timestamp + payload;
const signature = CryptoJS.HmacSHA256(message, secret).toString();

pm.request.headers.add({ key: 'X-API-KEY',   value: apiKey });
pm.request.headers.add({ key: 'X-TIMESTAMP', value: timestamp });
pm.request.headers.add({ key: 'X-SIGNATURE', value: signature });

