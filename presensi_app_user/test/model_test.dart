import 'package:flutter_test/flutter_test.dart';
import 'package:presensi_app_user/model/user_model.dart';
import 'package:presensi_app_user/model/presensi_model.dart';

void main() {
  group('UserModel Tests', () {
    test('Test 1: Membuat UserModel dari constructor', () {
      final user = UserModel(
        id: 1,
        nama: 'John Doe',
        email: 'john@example.com',
        divisi: 'IT',
        nip: '123456',
      );

      expect(user.id, 1);
      expect(user.nama, 'John Doe');
      expect(user.email, 'john@example.com');
      expect(user.divisi, 'IT');
      expect(user.nip, '123456');
    });

    test('Test 2: UserModel.fromJson parsing dengan benar', () {
      final json = {
        'user_id': 2,
        'nama': 'Jane Smith',
        'email': 'jane@example.com',
        'divisi': 'HR',
        'NIP': '654321',
      };

      final user = UserModel.fromJson(json);

      expect(user.id, 2);
      expect(user.nama, 'Jane Smith');
      expect(user.email, 'jane@example.com');
      expect(user.divisi, 'HR');
      expect(user.nip, '654321');
    });

    test('Test 3: UserModel.toJson menghasilkan Map yang benar', () {
      final user = UserModel(
        id: 3,
        nama: 'Bob Wilson',
        email: 'bob@example.com',
        divisi: 'Finance',
        nip: '789012',
      );

      final json = user.toJson();

      expect(json['user_id'], 3);
      expect(json['nama'], 'Bob Wilson');
      expect(json['email'], 'bob@example.com');
      expect(json['divisi'], 'Finance');
      expect(json['nip'], '789012');
    });

    test('Test 4: UserModel fromJson -> toJson consistency', () {
      final originalJson = {
        'user_id': 4,
        'nama': 'Alice Brown',
        'email': 'alice@example.com',
        'divisi': 'Marketing',
        'NIP': '345678',
      };

      final user = UserModel.fromJson(originalJson);
      final resultJson = user.toJson();

      expect(resultJson['user_id'], originalJson['user_id']);
      expect(resultJson['nama'], originalJson['nama']);
      expect(resultJson['email'], originalJson['email']);
      expect(resultJson['divisi'], originalJson['divisi']);
      expect(resultJson['nip'], originalJson['NIP']);
    });
  });

  group('PresensiModel Tests', () {
    test('Test 1: Membuat PresensiModel dengan constructor', () {
      final tanggal = DateTime(2026, 1, 27);
      final presensi = PresensiModel(
        id: '1',
        tanggal: tanggal,
        jamMasuk: '08:00',
        status: 'Hadir',
      );

      expect(presensi.id, '1');
      expect(presensi.tanggal, tanggal);
      expect(presensi.jamMasuk, '08:00');
      expect(presensi.status, 'Hadir');
    });

    test('Test 2: PresensiModel dengan jamMasuk null', () {
      final tanggal = DateTime(2026, 1, 27);
      final presensi = PresensiModel(
        id: '2',
        tanggal: tanggal,
        status: 'Alpha',
      );

      expect(presensi.id, '2');
      expect(presensi.tanggal, tanggal);
      expect(presensi.jamMasuk, null);
      expect(presensi.status, 'Alpha');
    });

    test('Test 3: PresensiModel dengan status Terlambat', () {
      final tanggal = DateTime(2026, 1, 27);
      final presensi = PresensiModel(
        id: '3',
        tanggal: tanggal,
        jamMasuk: '09:30',
        status: 'Terlambat',
      );

      expect(presensi.status, 'Terlambat');
      expect(presensi.jamMasuk, '09:30');
    });

    test('Test 4: PresensiModel dengan berbagai status', () {
      final tanggal = DateTime(2026, 1, 27);
      
      final statusList = ['Hadir', 'Terlambat', 'Izin', 'Sakit', 'Alpha'];
      
      for (var status in statusList) {
        final presensi = PresensiModel(
          id: status,
          tanggal: tanggal,
          jamMasuk: status == 'Alpha' ? null : '08:00',
          status: status,
        );
        
        expect(presensi.status, status);
      }
    });
  });
}

