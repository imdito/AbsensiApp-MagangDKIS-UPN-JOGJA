import 'package:flutter_test/flutter_test.dart';
import 'package:intl/intl.dart';
import 'package:intl/date_symbol_data_local.dart';

void main() {
  setUpAll(() async {
    await initializeDateFormatting('id_ID', null);
  });

  group('Date and Time Utility Tests', () {
    test('Test 1: Format tanggal Indonesia (dd MMMM yyyy)', () {
      final tanggal = DateTime(2026, 1, 27);
      final formatter = DateFormat('dd MMMM yyyy', 'id_ID');
      final result = formatter.format(tanggal);
      
      expect(result, contains('27'));
      expect(result, contains('2026'));
    });

    test('Test 2: Format jam (HH:mm)', () {
      final waktu = DateTime(2026, 1, 27, 8, 30);
      final formatter = DateFormat('HH:mm');
      final result = formatter.format(waktu);
      
      expect(result, '08:30');
    });

    test('Test 3: Format jam dengan AM/PM', () {
      final waktuPagi = DateTime(2026, 1, 27, 8, 30);
      final waktuSore = DateTime(2026, 1, 27, 14, 45);
      
      final formatter = DateFormat('hh:mm a');
      
      expect(formatter.format(waktuPagi), '08:30 AM');
      expect(formatter.format(waktuSore), '02:45 PM');
    });

    test('Test 4: Parsing string tanggal ke DateTime', () {
      final dateString = '2026-01-27';
      final parsed = DateTime.parse(dateString);
      
      expect(parsed.year, 2026);
      expect(parsed.month, 1);
      expect(parsed.day, 27);
    });

    test('Test 5: Menghitung selisih hari', () {
      final tanggal1 = DateTime(2026, 1, 27);
      final tanggal2 = DateTime(2026, 1, 30);
      
      final selisih = tanggal2.difference(tanggal1).inDays;
      
      expect(selisih, 3);
    });

    test('Test 6: Cek apakah hari ini weekend', () {
      // Sabtu = 6, Minggu = 7
      final sabtu = DateTime(2026, 1, 31); // 31 Jan 2026 adalah Sabtu
      final minggu = DateTime(2026, 2, 1);  // 1 Feb 2026 adalah Minggu
      final senin = DateTime(2026, 2, 2);   // 2 Feb 2026 adalah Senin
      
      bool isWeekend(DateTime date) {
        return date.weekday == DateTime.saturday || date.weekday == DateTime.sunday;
      }
      
      expect(isWeekend(sabtu), true);
      expect(isWeekend(minggu), true);
      expect(isWeekend(senin), false);
    });
  });

  group('String Validation Tests', () {
    test('Test 1: Email validation', () {
      bool isValidEmail(String email) {
        final emailRegex = RegExp(r'^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$');
        return emailRegex.hasMatch(email);
      }
      
      expect(isValidEmail('test@example.com'), true);
      expect(isValidEmail('user.name@company.co.id'), true);
      expect(isValidEmail('invalid.email'), false);
      expect(isValidEmail('@example.com'), false);
    });

    test('Test 2: NIP validation (hanya angka)', () {
      bool isValidNIP(String nip) {
        final nipRegex = RegExp(r'^\d+$');
        return nipRegex.hasMatch(nip) && nip.length >= 6;
      }
      
      expect(isValidNIP('123456'), true);
      expect(isValidNIP('12345678'), true);
      expect(isValidNIP('12345'), false);
      expect(isValidNIP('ABC123'), false);
    });

    test('Test 3: Nama tidak boleh kosong', () {
      bool isValidName(String name) {
        return name.trim().isNotEmpty && name.length >= 3;
      }
      
      expect(isValidName('John Doe'), true);
      expect(isValidName('Ali'), true);
      expect(isValidName(''), false);
      expect(isValidName('  '), false);
      expect(isValidName('AB'), false);
    });

    test('Test 4: Password minimal 6 karakter', () {
      bool isValidPassword(String password) {
        return password.length >= 6;
      }
      
      expect(isValidPassword('password123'), true);
      expect(isValidPassword('123456'), true);
      expect(isValidPassword('12345'), false);
      expect(isValidPassword(''), false);
    });
  });

  group('Status Presensi Helper Tests', () {
    test('Test 1: Tentukan status berdasarkan jam masuk', () {
      String getStatusFromTime(String jamMasuk) {
        final parts = jamMasuk.split(':');
        if (parts.length != 2) return 'Invalid';
        
        final jam = int.parse(parts[0]);
        final menit = int.parse(parts[1]);
        
        if (jam < 8 || (jam == 8 && menit == 0)) {
          return 'Hadir';
        } else if (jam == 8 && menit <= 15) {
          return 'Hadir';
        } else {
          return 'Terlambat';
        }
      }
      
      expect(getStatusFromTime('07:30'), 'Hadir');
      expect(getStatusFromTime('08:00'), 'Hadir');
      expect(getStatusFromTime('08:10'), 'Hadir');
      expect(getStatusFromTime('08:16'), 'Terlambat');
      expect(getStatusFromTime('09:00'), 'Terlambat');
    });

    test('Test 2: Warna badge berdasarkan status', () {
      String getColorFromStatus(String status) {
        switch (status.toLowerCase()) {
          case 'hadir':
            return 'green';
          case 'terlambat':
            return 'orange';
          case 'izin':
          case 'sakit':
            return 'blue';
          case 'alpha':
            return 'red';
          default:
            return 'grey';
        }
      }
      
      expect(getColorFromStatus('Hadir'), 'green');
      expect(getColorFromStatus('Terlambat'), 'orange');
      expect(getColorFromStatus('Izin'), 'blue');
      expect(getColorFromStatus('Sakit'), 'blue');
      expect(getColorFromStatus('Alpha'), 'red');
    });
  });

  group('List and Data Manipulation Tests', () {
    test('Test 1: Filter data presensi berdasarkan status', () {
      final presensiList = [
        {'status': 'Hadir'},
        {'status': 'Terlambat'},
        {'status': 'Hadir'},
        {'status': 'Alpha'},
      ];
      
      final hadirOnly = presensiList.where((p) => p['status'] == 'Hadir').toList();
      
      expect(hadirOnly.length, 2);
    });

    test('Test 2: Hitung total kehadiran per status', () {
      final presensiList = [
        {'status': 'Hadir'},
        {'status': 'Terlambat'},
        {'status': 'Hadir'},
        {'status': 'Hadir'},
        {'status': 'Alpha'},
      ];
      
      final hadirCount = presensiList.where((p) => p['status'] == 'Hadir').length;
      final terlambatCount = presensiList.where((p) => p['status'] == 'Terlambat').length;
      final alphaCount = presensiList.where((p) => p['status'] == 'Alpha').length;
      
      expect(hadirCount, 3);
      expect(terlambatCount, 1);
      expect(alphaCount, 1);
    });

    test('Test 3: Sort presensi berdasarkan tanggal', () {
      final presensiList = [
        {'tanggal': DateTime(2026, 1, 25)},
        {'tanggal': DateTime(2026, 1, 27)},
        {'tanggal': DateTime(2026, 1, 23)},
      ];
      
      presensiList.sort((a, b) => 
        (b['tanggal'] as DateTime).compareTo(a['tanggal'] as DateTime)
      );
      
      expect((presensiList[0]['tanggal'] as DateTime).day, 27);
      expect((presensiList[2]['tanggal'] as DateTime).day, 23);
    });
  });

  group('Edge Cases Tests', () {
    test('Test 1: Handle null values', () {
      String? nullableString;
      
      final result = nullableString ?? 'default';
      
      expect(result, 'default');
    });

    test('Test 2: Handle empty string', () {
      String emptyString = '';
      
      expect(emptyString.isEmpty, true);
      expect(emptyString.isNotEmpty, false);
    });

    test('Test 3: Handle invalid date format', () {
      expect(() => DateTime.parse('invalid-date'), throwsException);
    });

    test('Test 4: Handle division by zero prevention', () {
      int total = 10;
      int count = 0;
      
      double average = count > 0 ? total / count : 0;
      
      expect(average, 0);
    });
  });
}

