$ErrorActionPreference = "Stop"
[Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12
try {
    $uri = "ftp://ftpupload.net/htdocs/test.txt"
    $request = [System.Net.FtpWebRequest]::Create($uri)
    $request.Method = [System.Net.WebRequestMethods+Ftp]::UploadFile
    $request.Credentials = New-Object System.Net.NetworkCredential("if0_42583734", "GVx2qDjP3bazK")
    $request.EnableSsl = $true
    $request.UsePassive = $true
    $content = [System.Text.Encoding]::UTF8.GetBytes("test")
    $request.ContentLength = $content.Length
    $stream = $request.GetRequestStream()
    $stream.Write($content, 0, $content.Length)
    $stream.Close()
    $response = $request.GetResponse()
    $response.Close()
    Write-Host "SUCCESS: FTPS Upload works!"
} catch {
    Write-Host "ERROR: $($_.Exception.Message)"
    if ($_.Exception.InnerException) {
        Write-Host "INNER: $($_.Exception.InnerException.Message)"
    }
}
