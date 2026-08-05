$ftpHost = "ftpupload.net"
$ftpUser = "if0_42583591"
$ftpPass = "MCuWVO2q9HqBgoy"
$localPath = "C:\xampp\htdocs\RT-main"
$remotePath = "/htdocs"

function Upload-File($localFile, $remoteFile) {
    $uri = "ftp://" + $ftpHost + $remoteFile
    $request = [System.Net.FtpWebRequest]::Create($uri)
    $request.Method = [System.Net.WebRequestMethods+Ftp]::UploadFile
    $request.Credentials = New-Object System.Net.NetworkCredential($ftpUser, $ftpPass)
    $request.UseBinary = $true
    $request.UsePassive = $true
    $request.KeepAlive = $false
    $content = [System.IO.File]::ReadAllBytes($localFile)
    $request.ContentLength = $content.Length
    $stream = $request.GetRequestStream()
    $stream.Write($content, 0, $content.Length)
    $stream.Close()
    $response = $request.GetResponse()
    $response.Close()
}

function Create-FtpDir($remoteDir) {
    try {
        $uri = "ftp://" + $ftpHost + $remoteDir
        $request = [System.Net.FtpWebRequest]::Create($uri)
        $request.Method = [System.Net.WebRequestMethods+Ftp]::MakeDirectory
        $request.Credentials = New-Object System.Net.NetworkCredential($ftpUser, $ftpPass)
        $request.UsePassive = $true
        $response = $request.GetResponse()
        $response.Close()
    } catch {}
}

$files = Get-ChildItem -Path $localPath -Recurse -File | Where-Object { $_.FullName -notmatch "\.git" }
$total = $files.Count
$count = 0
foreach ($file in $files) {
    $relativePath = $file.FullName.Substring($localPath.Length).Replace("\", "/")
    $remoteFile = $remotePath + $relativePath
    $remoteDir = $remoteFile.Substring(0, $remoteFile.LastIndexOf("/"))
    Create-FtpDir $remoteDir
    try {
        Upload-File $file.FullName $remoteFile
        $count++
        Write-Host "Uploaded ($count/$total): $relativePath"
    } catch {
        Write-Host "FAILED: $relativePath"
    }
}
Write-Host "Upload complete! Files uploaded: $count"
