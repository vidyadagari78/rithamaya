from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.options import Options
import time
import os

ZIP_FILE = r"C:\xampp\htdocs\RT-main\site_upload.zip"

print("Starting Chrome browser...")
options = Options()
options.add_argument("--start-maximized")
# Use your existing Chrome profile to avoid bot detection
driver = webdriver.Chrome(options=options)
wait = WebDriverWait(driver, 30)

try:
    # Step 1: Login
    print("Step 1: Navigating to InfinityFree login...")
    driver.get("https://app.infinityfree.com/login")
    time.sleep(3)

    print("Step 2: Entering credentials...")
    email_field = wait.until(EC.presence_of_element_located((By.NAME, "email")))
    email_field.clear()
    email_field.send_keys("chandanap.murthy@gmail.com")

    pass_field = driver.find_element(By.NAME, "password")
    pass_field.clear()
    pass_field.send_keys("Krishna@02")

    login_btn = driver.find_element(By.XPATH, "//button[@type='submit'] | //input[@type='submit']")
    login_btn.click()
    time.sleep(5)
    print(f"After login URL: {driver.current_url}")

    # Step 2: Find and click Manage button
    print("Step 3: Finding hosting account...")
    time.sleep(3)
    
    # Look for Manage link for rithamayaa
    manage_links = driver.find_elements(By.XPATH, "//a[contains(@href, 'manage') or contains(text(), 'Manage')]")
    if manage_links:
        print(f"Found {len(manage_links)} manage links, clicking first...")
        manage_links[0].click()
        time.sleep(5)
        print(f"After manage URL: {driver.current_url}")
    else:
        print("No manage links found, trying direct URL...")
        # Try getting account ID from page
        links = driver.find_elements(By.XPATH, "//a[contains(@href, '/accounts/')]")
        for link in links:
            href = link.get_attribute('href')
            print(f"Found link: {href}")

    # Step 3: Open control panel
    print("Step 4: Looking for control panel / file manager link...")
    time.sleep(3)
    
    # Try to find Online File Manager link
    fm_links = driver.find_elements(By.XPATH, "//*[contains(text(), 'File Manager') or contains(text(), 'file manager')]")
    if fm_links:
        print("Found File Manager link!")
        fm_links[0].click()
        time.sleep(5)
    else:
        print("File manager not found directly, saving page source...")
        with open("page_debug.html", "w", encoding="utf-8") as f:
            f.write(driver.page_source[:10000])
        print("Saved page source to page_debug.html")

    print(f"Current URL: {driver.current_url}")
    print("Browser is open - checking for file manager...")
    
    # Keep browser open for 60 seconds so user can see
    time.sleep(10)
    print("Script finished. Check the browser window.")

except Exception as e:
    print(f"Error: {e}")
    import traceback
    traceback.print_exc()
    with open("error_debug.html", "w", encoding="utf-8") as f:
        try:
            f.write(driver.page_source[:10000])
        except:
            f.write("Could not get page source")
    input("Press Enter to close browser...")

finally:
    print("Done. Browser will stay open.")
