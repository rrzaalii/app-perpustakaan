Arsitektur Model, View, dan Controller (MVC) membagi fokus kode aplikasi menjadi tiga untuk memudahkan development:

1. **Model** digunakan untuk mengatur interaksi dengan database serta menjalankan logika-logika yang terkait dengan database tersebut.
2. **View** sesuai namanya digunakan untuk bagian interface yang berinteraksi langsung dengan pengguna di browser.
3. **Controller** digunakan sebagai penghubung utama untuk menerima permintaan dari pengguna, mengambil atau menyimpan data melalui model, lalu mengirimkan hasilnya ke View untuk ditampilkan.

> Menurut saya arsitektur MVC ini seperti restoran: **View** adalah Menu, **Controller** adalah Pelayan, dan **Model** adalah para staff di dapur (kitchen).