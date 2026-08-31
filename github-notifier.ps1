Add-Type -AssemblyName System.Windows.Forms

Write-Host "Monitoring GitHub repository for new changes..."
Write-Host "Checking every 60 seconds."

while ($true) {
    try {
        # Fetch data dari remote (tanpa mengubah file lokal)
        git fetch origin main -q
        
        # Cek berapa banyak commit baru yang ada di GitHub tapi belum ada di lokal
        $count = git rev-list HEAD...origin/main --count
        
        if ([int]$count -gt 0) {
            Write-Host "[$((Get-Date).ToString('HH:mm:ss'))] Ditemukan $count pembaruan baru dari GitHub!"
            
            # Tampilkan popup notifikasi Windows
            [System.Windows.Forms.MessageBox]::Show(
                "Ada $count perubahan/update baru di Github!`n`nSilakan jalankan perintah 'git pull' di terminal untuk mengunduhnya.", 
                "Notifikasi Update GitHub", 
                0, 
                [System.Windows.Forms.MessageBoxIcon]::Information
            )
            
            # Jeda 5 menit (300 detik) setelah notifikasi agar tidak spam popup terus-menerus
            # Jika user belum melakukan git pull, notifikasi akan muncul lagi setelah 5 menit.
            Start-Sleep -Seconds 300 
        } else {
            # Jika tidak ada update, tunggu 60 detik sebelum ngecek lagi
            Start-Sleep -Seconds 60
        }
    } catch {
        # Jika tidak ada koneksi internet atau error git, tunggu sebentar lalu coba lagi
        Start-Sleep -Seconds 60
    }
}
