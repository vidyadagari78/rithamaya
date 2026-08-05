import requests
import os
import re
import json

session = requests.Session()
session.headers.update({
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36"
})

print("Step 1: Getting login page...")
login_page = session.get("https://app.infinityfree.com/login", timeout=30)
print(f"Login page status: {login_page.status_code}")

# Extract CSRF token
csrf_match = re.search(r'name="_token"\s+value="([^"]+)"', login_page.text)
if not csrf_match:
    csrf_match = re.search(r'"_token"\s*:\s*"([^"]+)"', login_page.text)

csrf_token = csrf_match.group(1) if csrf_match else ""
print(f"CSRF token found: {'Yes' if csrf_token else 'No'}")

print("Step 2: Logging in...")
login_data = {
    "_token": csrf_token,
    "email": "chandanap.murthy@gmail.com",
    "password": "Krishna@02"
}
login_resp = session.post("https://app.infinityfree.com/login", data=login_data, timeout=30, allow_redirects=True)
print(f"Login response status: {login_resp.status_code}")
print(f"Login final URL: {login_resp.url}")

if "dashboard" in login_resp.url or "accounts" in login_resp.url:
    print("LOGIN SUCCESSFUL!")
else:
    print("Login may have failed or redirected. Current page URL:", login_resp.url)
    # Save page to debug
    with open("login_response.html", "w", encoding="utf-8") as f:
        f.write(login_resp.text[:5000])
    print("Saved first 5000 chars to login_response.html")

# Get accounts list
print("Step 3: Getting account list...")
accounts = session.get("https://app.infinityfree.com/accounts", timeout=30)
print(f"Accounts page status: {accounts.status_code}")
print(f"Accounts URL: {accounts.url}")

# Look for account ID
account_match = re.search(r'/accounts/([a-zA-Z0-9_]+)/manage', accounts.text)
if account_match:
    account_id = account_match.group(1)
    print(f"Found account ID: {account_id}")
else:
    print("Could not find account ID automatically")
    with open("accounts_response.html", "w", encoding="utf-8") as f:
        f.write(accounts.text[:8000])
    print("Saved accounts page to accounts_response.html for debugging")
