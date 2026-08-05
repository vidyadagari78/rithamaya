import ftplib

try:
    print("Connecting to ftpupload.net...")
    ftp = ftplib.FTP('ftpupload.net', timeout=30)
    print("Logging in...")
    ftp.login('if0_42583734', 'GVx2qDjP3bazK')
    print("Login successful!")
    ftp.cwd('htdocs')
    print("Current directory:", ftp.pwd())
    
    # Try to delete the placeholder file
    try:
        ftp.delete('index2.html')
        print("Deleted index2.html")
    except Exception as e:
        print("Could not delete index2.html:", e)
        
    print("FTP Connection works!")
    ftp.quit()
except Exception as e:
    print("FTP Error:", e)
