# Unit Testing - Presensi App User

## Deskripsi
Repository ini berisi unit test lengkap untuk aplikasi Presensi berbasis Flutter yang menggunakan QR Code.

## File Test yang Dibuat

### 1. `test/widget_test.dart`
Test untuk widget dan UI aplikasi:
- ✅ Cek apakah aplikasi bisa dibuka
- ✅ Verifikasi GetMaterialApp termuat
- ✅ Cek tema aplikasi menggunakan Material 3
- ✅ Cek title aplikasi
- ✅ Cek debug banner dimatikan

**Total: 5 tests**

### 2. `test/model_test.dart`
Test untuk data model:

#### UserModel Tests:
- ✅ Membuat UserModel dari constructor
- ✅ UserModel.fromJson parsing dengan benar
- ✅ UserModel.toJson menghasilkan Map yang benar
- ✅ UserModel fromJson -> toJson consistency

#### PresensiModel Tests:
- ✅ Membuat PresensiModel dengan constructor
- ✅ PresensiModel dengan jamMasuk null
- ✅ PresensiModel dengan status Terlambat
- ✅ PresensiModel dengan berbagai status

**Total: 8 tests**

### 3. `test/controller_test.dart`
Test untuk controller dan business logic:

#### HomeController Tests:
- ✅ jamMasuk dan jamPulang memiliki nilai default
- ✅ statusHari() return "Pagi" untuk jam < 9
- ✅ statusHari() return "Siang" untuk jam 9-14
- ✅ statusHari() return "Sore" untuk jam 15-17
- ✅ statusHari() return "Malam" untuk jam >= 18

#### Observable Variables Tests:
- ✅ Rx String dapat diubah nilainya
- ✅ Rx String dapat di-listen perubahannya

#### DateTime Logic Tests:
- ✅ DateTime.now() memberikan waktu saat ini
- ✅ Perbandingan jam dengan DateTime

**Total: 9 tests**

### 4. `test/utility_test.dart`
Test untuk utility functions dan helper methods:

#### Date and Time Utility Tests:
- ✅ Format tanggal Indonesia (dd MMMM yyyy)
- ✅ Format jam (HH:mm)
- ✅ Format jam dengan AM/PM
- ✅ Parsing string tanggal ke DateTime
- ✅ Menghitung selisih hari
- ✅ Cek apakah hari ini weekend

#### String Validation Tests:
- ✅ Email validation
- ✅ NIP validation (hanya angka)
- ✅ Nama tidak boleh kosong
- ✅ Password minimal 6 karakter

#### Status Presensi Helper Tests:
- ✅ Tentukan status berdasarkan jam masuk
- ✅ Warna badge berdasarkan status

#### List and Data Manipulation Tests:
- ✅ Filter data presensi berdasarkan status
- ✅ Hitung total kehadiran per status
- ✅ Sort presensi berdasarkan tanggal

#### Edge Cases Tests:
- ✅ Handle null values
- ✅ Handle empty string
- ✅ Handle invalid date format
- ✅ Handle division by zero prevention

**Total: 19 tests**

## Total Coverage
**41 unit tests berhasil dibuat dan lolos semua! ✅**

## Cara Menjalankan Test

### Menjalankan Semua Test
```bash
flutter test
```

### Menjalankan Test dengan Output Detail
```bash
flutter test -r expanded
```

### Menjalankan Test Spesifik
```bash
# Test untuk model
flutter test test/model_test.dart

# Test untuk controller
flutter test test/controller_test.dart

# Test untuk utility
flutter test test/utility_test.dart

# Test untuk widget
flutter test test/widget_test.dart
```

### Menjalankan Test dengan Coverage
```bash
flutter test --coverage
```

## Struktur File Test

```
test/
├── widget_test.dart      # Widget & UI tests
├── model_test.dart       # Data model tests
├── controller_test.dart  # Controller & business logic tests
└── utility_test.dart     # Utility & helper function tests
```

## Dependencies untuk Testing

Pastikan file `pubspec.yaml` Anda memiliki dependencies berikut:

```yaml
dev_dependencies:
  flutter_test:
    sdk: flutter
  flutter_lints: ^4.0.0
```

Dependencies yang digunakan dalam test:
- `flutter_test`: Framework testing Flutter
- `get`: State management (untuk GetX)
- `intl`: Formatting tanggal dan lokalisasi

## Catatan Penting

1. **Timer Handling**: Widget test menangani Timer dari SplashController dengan:
   ```dart
   await tester.pump();
   await tester.pump(const Duration(seconds: 2));
   ```

2. **Locale Initialization**: Utility test menginisialisasi locale Indonesia dengan:
   ```dart
   setUpAll(() async {
     await initializeDateFormatting('id_ID', null);
   });
   ```

3. **GetX Testing**: Controller test menggunakan `Get.testMode = true` untuk testing GetX.

## Best Practices

- ✅ Setiap test harus independen dan tidak bergantung pada test lain
- ✅ Gunakan `setUp()` dan `tearDown()` untuk inisialisasi dan cleanup
- ✅ Test harus cepat dan deterministik
- ✅ Gunakan descriptive test names
- ✅ Test edge cases dan error handling

## Continuous Integration (CI)

Anda dapat menambahkan GitHub Actions untuk otomatis menjalankan test:

```yaml
# .github/workflows/test.yml
name: Flutter Test

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - uses: subosito/flutter-action@v2
        with:
          flutter-version: '3.x'
      - run: flutter pub get
      - run: flutter test
```

## Troubleshooting

### Error: "Locale data has not been initialized"
**Solusi**: Tambahkan `setUpAll()` dengan `initializeDateFormatting()`:
```dart
setUpAll(() async {
  await initializeDateFormatting('id_ID', null);
});
```

### Error: "A Timer is still pending"
**Solusi**: Tambahkan `pump(Duration)` untuk menangani timer:
```dart
await tester.pump(const Duration(seconds: 2));
```

### Error: "GetInstance not initialized"
**Solusi**: Gunakan `Get.testMode = true` dan reset di `tearDown()`:
```dart
tearDown(() {
  Get.reset();
});
```

## Contributing

Untuk menambahkan test baru:
1. Buat file test di folder `test/`
2. Import dependencies yang diperlukan
3. Gunakan structure `group()` dan `test()`
4. Jalankan test untuk verifikasi
5. Update README ini dengan informasi test baru

## Author
Dibuat untuk proyek Presensi App User - Flutter Application

## License
MIT License

